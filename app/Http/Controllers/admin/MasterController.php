<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Package;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MasterController extends Controller
{
    protected function render(string $view, array $data = [])
    {
        return view($view, array_merge([
            'user' => Auth::user(),
        ], $data));
    }

    public function companySetup()
    {
        return $this->render('admin.pages.master.company-setup');
    }

    public function adminRegister()
    {
        $admin = Admin::first();
        return $this->render('admin.pages.master.admin-register', [
            'admin' => $admin,
        ]);
    }

    /**
     * Handle Admin Action (Update & Delete Only - No Create)
     */
    public function handleAdminAction(Request $request)
    {
        $curdate = Carbon::now()->format('Y-m-d H:i:s');
        $log_user = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';

        // ── 1. Delete Admin Logic ──
        $delid = $request->input('delid') ?? ($request->input('action') === 'delete' ? $request->input('admin_id') : null);
        if (!empty($delid) || $request->input('action') === 'delete') {
            $targetId = !empty($delid) ? $delid : $request->input('admin_id');
            $admin = !empty($targetId) ? Admin::where('admin_id', $targetId)->first() : Admin::first();

            if ($admin) {
                $admin->delete();
                return response()->json([
                    'status'  => 'success',
                    'errmsg'  => 3,
                    'message' => 'Admin record deleted successfully.',
                    'admin'   => Admin::first(),
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'errmsg'  => 0,
                'message' => 'Admin record not found to delete.',
            ], 404);
        }

        // ── 2. Update Admin Logic ──
        $adminId = $request->input('admin_id');

        if (empty($adminId)) {
            return response()->json([
                'status'  => 'error',
                'errmsg'  => 0,
                'message' => 'Admin ID is required for update.',
            ], 400);
        }

        $admin = Admin::where('admin_id', $adminId)->first();
        if (!$admin) {
            return response()->json([
                'status'  => 'error',
                'errmsg'  => 0,
                'message' => 'Admin record not found to update.',
            ], 404);
        }

        // Exact form input names
        $adminName     = trim((string) $request->input('admin_name', ''));
        $adminMobile   = $request->input('admin_mobile');
        $adminLoginId  = $request->input('admin_login_id');
        $adminEmail    = $request->input('admin_email');
        $adminStatus   = $request->input('admin_status');
        $adminPassword = $request->input('admin_password');

        // Split admin_name into fname and lname
        $nameParts = explode(' ', $adminName, 2);
        $fname = $nameParts[0] ?? '';
        $lname = $nameParts[1] ?? '';

        $updateData = [
            'admin_fname'    => $fname,
            'admin_lname'    => $lname,
            'mob_one'        => $adminMobile,
            'admin_username' => $adminLoginId,
            'email_id'       => $adminEmail,
            'status'         => in_array((string) $adminStatus, ['1', 'ACTIVE', 'active'], true) ? '1' : '0',
            'update_date'    => $curdate,
            'update_user'    => $log_user,
        ];

       

        // Only update password if a new password is provided
        if (!empty(trim((string) $adminPassword))) {
          
            $updateData['admin_password'] = Hash::make($adminPassword);
        }
   
        
        $admin->update($updateData);

        return response()->json([
            'status'  => 'success',
            'errmsg'  => 2,
            'message' => 'Admin details updated successfully.',
            'admin'   => $admin->fresh(),
        ]);
    }

    public function userRegister()
    {
        $userTypes = UserType::where('status', '1')->orderBy('id')->get();
        $packages  = Package::where('status', '1')->orderBy('id')->get();
        $users     = User::orderBy('id', 'desc')->get();

        return $this->render('admin.pages.master.user-register', [
            'userTypes' => $userTypes,
            'packages'  => $packages,
            'users'     => $users,
        ]);
    }

    /**
     * Handle User Action (Create, Update & Delete)
     */
    public function handleUserAction(Request $request)
    {
        $now = Carbon::now();
        $logUser = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';

        // ── 1. Delete Action ──
        $delId = $request->input('delid') ?? ($request->input('action') === 'delete' ? $request->input('user_id') : null);
        if (!empty($delId)) {
            $user = User::find($delId);
            if ($user) {
                $delRegNo = $user->regno;
                $user->delete();

                try {
                    DB::table('b5_api_user_ip_tbl')->where('userid', $delId)->delete();
                    if (!empty($delRegNo)) {
                        DB::table('b4_api_user_tran_lazer_tbl')->where('uregno', $delRegNo)->delete();
                        DB::table('b3_api_user_payout_tbl')->where('uregno', $delRegNo)->delete();
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $delRegNo)->delete();
                        DB::table('sms_1_sender_id')->where('user_id', $delId)->delete();
                    }
                } catch (\Exception $e) {}

                return response()->json(['status' => 'success', 'errmsg' => 3, 'message' => 'User deleted successfully.']);
            }
            return response()->json(['status' => 'error', 'errmsg' => 0, 'message' => 'User not found to delete.'], 404);
        }

        // ── 2. Create / Update Action ──
        $contact = trim((string)($request->input('phone') ?? $request->input('contact', '')));
        if (empty($contact)) {
            return response()->json(['status' => 'error', 'errmsg' => 0, 'message' => 'Please enter Contact Number!'], 422);
        }

        $editId = $request->input('editid') ?? $request->input('user_id');

        // Check duplicate mobile
        $exists = User::where('userid', $contact)->when($editId, fn($q) => $q->where('id', '<>', $editId))->exists();
        if ($exists) {
            return response()->json(['status' => 'error', 'errmsg' => 0, 'message' => 'Mobile number already registered!'], 422);
        }

        $otpVal    = in_array(strtoupper((string)$request->input('isotpverify')), ['1', 'Y', 'YES']) ? '1' : '0';
        $sexVal    = (string)$request->input('sex') === '0' ? '0' : '1';
        $statusVal = in_array(strtoupper((string)$request->input('status')), ['1', 'ACTIVE', 'Y', 'YES']) ? '1' : '0';

        $userData = [
            'regtype'       => (string)($request->input('regtype') ?? $request->input('usertype', '4')),
            'isotpverify'   => $otpVal,
            'otpverifytype' => '0',
            'fname'         => trim((string)($request->input('fname') ?? $request->input('firstname', ''))),
            'lname'         => trim((string)($request->input('lname') ?? $request->input('lastname', ''))),
            'phone'         => $contact,
            'email'         => trim((string)$request->input('email', '')),
            'dob'           => (string)$request->input('dob', ''),
            'sex'           => $sexVal,
            'addsdt'        => trim((string)($request->input('addsdt') ?? $request->input('address', ''))),
            'landmark'      => trim((string)$request->input('landmark', '')),
            'nation'        => trim((string)($request->input('nation') ?? $request->input('nationality', 'INDIAN'))),
            'pincode'       => trim((string)($request->input('pincode') ?? $request->input('pinno', ''))),
            'panno'         => strtoupper(trim((string)$request->input('panno', ''))),
            'company_name'  => trim((string)($request->input('company_name') ?? $request->input('comname', ''))),
            'gstnumber'     => strtoupper(trim((string)($request->input('gstnumber') ?? $request->input('gstno', '')))),
            'aadharno'      => trim((string)$request->input('aadharno', '')),
            'ipaddress'     => trim((string)($request->input('ipaddress') ?? $request->input('uip', ''))),
            'callbackurl'   => trim((string)($request->input('callbackurl') ?? $request->input('callurl', ''))),
            'status'        => $statusVal,
            'package_id'    => (int)($request->input('package_id') ?? $request->input('packname', 1)),
            'lockamt'       => (float)($request->input('lockamt') ?: 0),
        ];

        if (empty($editId)) {
            // Generate unique API Token
            do {
                $apiToken = Str::random(32);
            } while (User::where('apitoken', $apiToken)->exists());

            // Sequence autono
            $autoRow = DB::table('api_user_autono_tbl')->limit(1)->first();
            $regNo = $autoRow ? $autoRow->incno : '';
            DB::table('api_user_autono_tbl')->where('id', '>=', 1)->increment('incno');

            $user = User::create(array_merge($userData, [
                'regno'       => $regNo,
                'apitoken'    => $apiToken,
                'regamt'      => 0,
                'userid'      => $contact,
                'userpass'    => Hash::make('123456'),
                'regst_date'  => $now->format('Y-m-d'),
                'regst_time'  => $now->format('h:i:s A'),
                'insert_date' => $now->format('Y-m-d H:i:s'),
                'insert_user' => $logUser,
            ]));

            try {
                DB::table('b4_api_user_balance_sheet_tbl')->insert([
                    'uregno'      => $regNo,
                    'regamt'      => 0,
                    'balance_amt' => 0,
                    'status'      => '1',
                    'insert_date' => $now->format('Y-m-d H:i:s'),
                    'insert_user' => $logUser,
                ]);
            } catch (\Exception $e) {}

            return response()->json(['status' => 'success', 'errmsg' => 1, 'message' => 'User registered successfully!', 'user' => $user]);
        }

        $user = User::findOrFail($editId);
        $user->update(array_merge($userData, [
            'update_date' => $now->format('Y-m-d H:i:s'),
            'update_user' => $logUser,
        ]));

        try {
            if (!empty($user->regno) && Schema::hasTable('aeps_kyc_application')) {
                DB::table('aeps_kyc_application')->where('regno', $user->regno)->update([
                    'pincode' => $userData['pincode'],
                    'aadhaar' => $userData['aadharno'],
                    'pancard' => $userData['panno'],
                ]);
            }
        } catch (\Exception $e) {}

        return response()->json(['status' => 'success', 'errmsg' => 2, 'message' => 'User details updated successfully!', 'user' => $user->fresh()]);
    }
}

