<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    protected function render(string $view, array $data = [])
    {
        return view($view, array_merge([
            'user' => Auth::user(),
        ], $data));
    }

    public function newPackage()
    {
        $packages = Package::orderBy('id', 'desc')->get();

        return $this->render('admin.pages.package.new-package', [
            'packages' => $packages,
        ]);
    }

    /**
     * Handle Package Action (Create, Update & Delete)
     */
    public function handlePackageAction(Request $request)
    {
        $now = Carbon::now();
        $logUser = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';

        // ── 1. Delete Action ──
        $delId = $request->input('delid') ?? ($request->input('action') === 'delete' ? $request->input('package_id') : null);
        if (!empty($delId)) {
            $package = Package::find($delId);
            if ($package) {
                $package->delete();
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Package plan deleted successfully.',
                ]);
            }
            return response()->json([
                'status'  => 'error',
                'message' => 'Package record not found to delete.',
            ], 404);
        }

        // ── 2. Create / Update Action ──
        $packName   = trim((string)$request->input('pack_name', $request->input('package_name', '')));
        $smsCharges = $request->input('pacch', $request->input('per_sms_charges', ''));
        $whCharges  = $request->input('whch', $request->input('per_wh_charges', '0.0000'));
        $status     = $request->input('status', '1');
        $editId     = $request->input('editid') ?? $request->input('package_id');

        if (empty($packName)) {
            return response()->json(['status' => 'error', 'message' => 'Please enter Package Name!'], 422);
        }
        if ($smsCharges === '' || !is_numeric($smsCharges) || (float)$smsCharges < 0) {
            return response()->json(['status' => 'error', 'message' => 'Please enter valid Per SMS Charges!'], 422);
        }
        if ($whCharges === '' || !is_numeric($whCharges) || (float)$whCharges < 0) {
            return response()->json(['status' => 'error', 'message' => 'Please enter valid Per WH Charges!'], 422);
        }

        // Duplicate Package Name Check (case-insensitive)
        $exists = Package::whereRaw('LOWER(pack_name) = ?', [strtolower($packName)])
            ->when($editId, fn($q) => $q->where('id', '<>', $editId))
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Package name already registered! Please choose a different name.',
            ], 422);
        }

        $statusVal = in_array(strtoupper((string)$status), ['1', 'Y', 'YES', 'ACTIVE']) ? '1' : '0';

        $packageData = [
            'refuserid'      => 0,
            'pack_name'      => $packName,
            'pacch'          => number_format((float)$smsCharges, 4, '.', ''),
            'whch'           => number_format((float)$whCharges, 4, '.', ''),
            'apistatus'      => '1',
            'default_status' => '0',
            'status'         => $statusVal,
        ];

        // ── CREATE NEW PACKAGE RECORD ──
        if (empty($editId)) {
            $package = Package::create(array_merge($packageData, [
                'insert_date' => $now->format('Y-m-d H:i:s'),
                'insert_user' => $logUser,
            ]));

            $formattedInsertDate = $package->insert_date ? Carbon::parse($package->insert_date)->format('d-m-Y') : '-';
            $formattedUpdateDate = $package->update_date ? Carbon::parse($package->update_date)->format('d-m-Y') : '-';

            return response()->json([
                'status'  => 'success',
                'message' => 'Package plan added successfully!',
                'package' => array_merge($package->toArray(), [
                    'insert_date_formatted' => $formattedInsertDate,
                    'update_date_formatted' => $formattedUpdateDate,
                ]),
            ]);
        }

        // ── UPDATE EXISTING PACKAGE RECORD ──
        $package = Package::find($editId);
        if (!$package) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Package record not found to update.',
            ], 404);
        }

        $package->update(array_merge($packageData, [
            'update_date' => $now->format('Y-m-d H:i:s'),
            'update_user' => $logUser,
        ]));

        $freshPackage = $package->fresh();
        $formattedInsertDate = $freshPackage->insert_date ? Carbon::parse($freshPackage->insert_date)->format('d-m-Y') : '-';
        $formattedUpdateDate = $freshPackage->update_date ? Carbon::parse($freshPackage->update_date)->format('d-m-Y') : '-';

        return response()->json([
            'status'  => 'success',
            'message' => 'Package plan updated successfully!',
            'package' => array_merge($freshPackage->toArray(), [
                'insert_date_formatted' => $formattedInsertDate,
                'update_date_formatted' => $formattedUpdateDate,
            ]),
        ]);
    }
}
