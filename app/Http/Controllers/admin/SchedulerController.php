<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SmsApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchedulerController extends Controller
{
    protected function render(string $view, array $data = [])
    {
        return view($view, array_merge([
            'user' => Auth::user(),
        ], $data));
    }

    public function smsApi()
    {
        $smsApis = SmsApi::orderBy('id', 'asc')->get();

        $totalGateways = $smsApis->count();
        $activeGateways = $smsApis->filter(function ($api) {
            return in_array(strtoupper((string)$api->status), ['1', 'ACTIVE', 'Y', 'YES'], true);
        })->count();
        $inactiveGateways = $totalGateways - $activeGateways;
        $primaryGateway = $smsApis->first(function ($api) {
            return in_array(strtoupper((string)$api->status), ['1', 'ACTIVE', 'Y', 'YES'], true);
        });

        return $this->render('admin.pages.scheduler.sms-api', [
            'smsApis'          => $smsApis,
            'totalGateways'    => $totalGateways,
            'activeGateways'   => $activeGateways,
            'inactiveGateways' => $inactiveGateways,
            'primaryGateway'   => $primaryGateway,
        ]);
    }

    /**
     * Handle SMS API Action (Create, Update & Delete)
     */
    public function handleSmsApiAction(Request $request)
    {
        $now = Carbon::now();
        $logUser = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';

        // ── 1. Delete Action ──
        $delId = $request->input('delid') ?? ($request->input('action') === 'delete' ? $request->input('api_id') : null);
        if (!empty($delId)) {
            $api = SmsApi::find($delId);
            if ($api) {
                $api->delete();
                return response()->json([
                    'status'  => 'success',
                    'message' => 'SMS Gateway API deleted successfully.',
                ]);
            }
            return response()->json([
                'status'  => 'error',
                'message' => 'SMS Gateway API record not found to delete.',
            ], 404);
        }

        // ── 2. Create / Update Action ──
        $vendorName = trim((string)$request->input('vendor_name', ''));
        $apiName    = trim((string)$request->input('apiname', $request->input('api_name', '')));
        $apiType    = trim((string)$request->input('apitype', $request->input('api_type', 'SMS API')));
        $status     = $request->input('status', '1');
        $editId     = $request->input('editid') ?? $request->input('api_id');

        if (empty($vendorName)) {
            return response()->json(['status' => 'error', 'message' => 'Please enter Vendor Name!'], 422);
        }
        
        $cleanVendor = trim(str_replace(['(', ')'], '', $vendorName));
        if (empty($apiName)) {
            $apiName = $cleanVendor;
        }
        if (empty($apiType)) {
            $apiType = 'SMS API';
        }

        $statusVal = in_array(strtoupper((string)$status), ['1', 'Y', 'YES', 'ACTIVE'], true) ? '1' : '0';

        $apiData = [
            'vendor_name' => str_starts_with($vendorName, '(') ? $vendorName : '(' . $vendorName . ')',
            'apiname'     => $apiName,
            'apitype'     => $apiType,
            'status'      => $statusVal,
            'lastch_date' => $now->format('Y-m-d'),
            'lastch_time' => $now->format('h:i:s A'),
        ];

        // ── CREATE NEW SMS API RECORD ──
        if (empty($editId)) {
            try {
                $maxApiNo = (int) SmsApi::max('apino');
                $apiNo = $request->input('apino') ? (int)$request->input('apino') : ($maxApiNo + 1);

                $api = SmsApi::create(array_merge($apiData, [
                    'apino'       => $apiNo,
                    'insert_date' => $now->format('Y-m-d H:i:s'),
                    'insert_user' => $logUser,
                ]));

                return response()->json([
                    'status'  => 'success',
                    'message' => 'New SMS Gateway API registered successfully!',
                    'api'     => array_merge($api->toArray(), [
                        'change_datetime' => $now->format('d/m/Y h:i:s A'),
                        'is_active'       => $statusVal === '1',
                    ]),
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Failed to save: ' . $e->getMessage()], 500);
            }
        }

        // ── UPDATE EXISTING SMS API RECORD ──
        try {
            $api = SmsApi::find($editId);
            if (!$api) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'SMS Gateway API record not found to update.',
                ], 404);
            }

            if ($request->filled('apino')) {
                $apiData['apino'] = (int)$request->input('apino');
            }

            $api->update(array_merge($apiData, [
                'update_date' => $now->format('Y-m-d H:i:s'),
                'update_user' => $logUser,
            ]));

            $fresh = $api->fresh();

            return response()->json([
                'status'  => 'success',
                'message' => 'SMS Gateway API details updated successfully!',
                'api'     => array_merge($fresh->toArray(), [
                    'change_datetime' => $now->format('d/m/Y h:i:s A'),
                    'is_active'       => $statusVal === '1',
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to update: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Toggle Gateway Status (Activate / Deactivate) with Secret Key Verification
     */
    public function toggleStatus(Request $request)
    {
        $now = Carbon::now();
        $logUser = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';

        $apiId = $request->input('id') ?? $request->input('api_id');
        if (empty($apiId)) {
            return response()->json(['status' => 'error', 'message' => 'API Gateway ID is required.'], 422);
        }

        $secretKey = (string)$request->input('secret_key');
        if ($secretKey === '') {
            return response()->json(['status' => 'error', 'message' => 'Please enter Secret Key!'], 422);
        }

        // Validate Secret Key exclusively against hashed key in .env
        $envSecretHash = env('ADMIN_SECRET_KEY_HASH', '$2y$12$Oyg/exnx.8iLNeKYjKjtNO6ZcgulSu98G1Znl3hxaUZbt/a6xUV/.');

        if (!Hash::check($secretKey, $envSecretHash)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid Secret Key! Authorization failed.',
            ], 403);
        }

        try {
            $api = SmsApi::find($apiId);
            if (!$api) {
                return response()->json(['status' => 'error', 'message' => 'SMS Gateway API record not found.'], 404);
            }

            $isCurrentlyActive = in_array(strtoupper((string)$api->status), ['1', 'Y', 'YES', 'ACTIVE'], true);
            $newStatusVal = $isCurrentlyActive ? '0' : '1';

            $api->update([
                'status'      => $newStatusVal,
                'lastch_date' => $now->format('Y-m-d'),
                'lastch_time' => $now->format('h:i:s A'),
                'update_date' => $now->format('Y-m-d H:i:s'),
                'update_user' => $logUser,
            ]);

            $statusLabel = $newStatusVal === '1' ? 'ACTIVE' : 'INACTIVE';
            $formattedDateTime = $now->format('d/m/Y h:i:s A');

            return response()->json([
                'status'          => 'success',
                'message'         => 'Gateway status changed to ' . $statusLabel . ' successfully!',
                'new_status'      => $newStatusVal === '1' ? 'active' : 'inactive',
                'status_label'    => $statusLabel,
                'is_active'       => $newStatusVal === '1',
                'change_datetime' => $formattedDateTime,
                'api'             => $api->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Toggle failed: ' . $e->getMessage()], 500);
        }
    }
}
