<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ApiTransactionDetail;
use App\Models\FundTransfer;
use App\Models\User;
use App\Models\UserTranLazer;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected function render(string $view, array $data = [])
    {
        return view($view, array_merge([
            'user' => Auth::user(),
        ], $data));
    }

    public function smsDetails(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = ApiTransactionDetail::with('user')->orderBy('id', 'desc');

                if ($request->filled('tran_id')) {
                    $query->where('servid', 'like', '%' . $request->tran_id . '%');
                }
                if ($request->filled('recharge_no')) {
                    $query->where('rechargeno', 'like', '%' . $request->recharge_no . '%');
                }
                if ($request->filled('operator_name')) {
                    $query->where(function($q) use ($request) {
                        $q->where('smsapi', 'like', '%' . $request->operator_name . '%')
                          ->orWhere('sender_id', 'like', '%' . $request->operator_name . '%');
                    });
                }
                if ($request->filled('from_date')) {
                    $query->whereDate('trandate', '>=', $request->from_date);
                }
                if ($request->filled('to_date')) {
                    $query->whereDate('trandate', '<=', $request->to_date);
                }
                if ($request->filled('user_name')) {
                    $userName = $request->user_name;
                    $query->whereHas('user', function($q) use ($userName) {
                        $q->where('fname', 'like', '%' . $userName . '%')
                          ->orWhere('lname', 'like', '%' . $userName . '%')
                          ->orWhere('regno', 'like', '%' . $userName . '%');
                    });
                }

                $perPage = 10;
                $paginated = $query->paginate($perPage);

                return response()->json([
                    'status' => 'success',
                    'data' => $paginated->items(),
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                    'from' => $paginated->firstItem() ?? 0,
                    'to' => $paginated->lastItem() ?? 0,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => [],
                    'total' => 0,
                ], 500);
            }
        }

        return $this->render('admin.pages.reports.sms-details');
    }

    public function smsLivePanel(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $query = ApiTransactionDetail::with('user')->orderBy('id', 'desc');

                if ($request->filled('tran_id')) {
                    $query->where('servid', 'like', '%' . $request->tran_id . '%');
                }
                if ($request->filled('recharge_no')) {
                    $query->where('rechargeno', 'like', '%' . $request->recharge_no . '%');
                }
                if ($request->filled('operator_name')) {
                    $query->where(function($q) use ($request) {
                        $q->where('smsapi', 'like', '%' . $request->operator_name . '%')
                          ->orWhere('sender_id', 'like', '%' . $request->operator_name . '%');
                    });
                }
                if ($request->filled('from_date')) {
                    $query->whereDate('trandate', '>=', $request->from_date);
                }
                if ($request->filled('to_date')) {
                    $query->whereDate('trandate', '<=', $request->to_date);
                }
                if ($request->filled('user_name')) {
                    $userName = $request->user_name;
                    $query->whereHas('user', function($q) use ($userName) {
                        $q->where('fname', 'like', '%' . $userName . '%')
                          ->orWhere('lname', 'like', '%' . $userName . '%')
                          ->orWhere('regno', 'like', '%' . $userName . '%');
                    });
                }
                if ($request->filled('quick_search')) {
                    $search = $request->quick_search;
                    $query->where(function($q) use ($search) {
                        $q->where('servid', 'like', '%' . $search . '%')
                          ->orWhere('sender_id', 'like', '%' . $search . '%')
                          ->orWhere('rechargeno', 'like', '%' . $search . '%')
                          ->orWhere('smsapi', 'like', '%' . $search . '%')
                          ->orWhere('smstext', 'like', '%' . $search . '%')
                          ->orWhereHas('user', function($uq) use ($search) {
                              $uq->where('fname', 'like', '%' . $search . '%')
                                 ->orWhere('lname', 'like', '%' . $search . '%')
                                 ->orWhere('company_name', 'like', '%' . $search . '%')
                                 ->orWhere('regno', 'like', '%' . $search . '%');
                          });
                    });
                }

                // ── Dynamic CSV Export ──
                if ($request->get('export') === 'csv') {
                    $trans = $query->limit(2000)->get();
                    $filename = 'sms-live-panel-' . date('Y-m-d_His') . '.csv';

                    $headers = [
                        'Content-Type'        => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                        'Pragma'              => 'no-cache',
                        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                        'Expires'             => '0',
                    ];

                    $callback = function () use ($trans) {
                        $file = fopen('php://output', 'w');
                        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                        fputcsv($file, [
                            '#',
                            'TRAN ID',
                            'SMS TEXT',
                            'SENDER ID',
                            'ENTITY ID',
                            'SEND TO',
                            'STATUS',
                            'CREDIT USE',
                            'CHARGES',
                            'TRAN DATE/TIME',
                            'USER DETAILS',
                        ]);

                        foreach ($trans as $index => $t) {
                            $userName = $t->user ? trim(($t->user->fname ?? '') . ' ' . ($t->user->lname ?? '')) : '-';
                            $company = $t->user ? ($t->user->company_name ?? '-') : '-';
                            $statusStr = (string)$t->status === '1' ? 'SUCCESS' : ((string)$t->status === '2' ? 'FAILED' : 'PENDING');
                            $transDateTime = ($t->trandate ?? '') . ' ' . ($t->trantime ?? '');

                            fputcsv($file, [
                                $index + 1,
                                $t->servid ?? '-',
                                $t->smstext ?? '-',
                                $t->sender_id ?? '-',
                                $t->entityid ?? '-',
                                $t->rechargeno ?? '-',
                                $statusStr,
                                $t->credit_use ?? 1,
                                number_format((float)($t->sms_charge ?? 0), 2, '.', ''),
                                trim($transDateTime) ?: '-',
                                "{$userName} ({$company})",
                            ]);
                        }
                        fclose($file);
                    };

                    return response()->stream($callback, 200, $headers);
                }

                // ── Dynamic Printable View ──
                if ($request->get('print') === '1') {
                    $transactions = $query->limit(2000)->get();

                    return view('admin.pages.reports.sms-live-panel-print', [
                        'transactions' => $transactions,
                        'filters'      => $request->all(),
                    ]);
                }

                $perPage = 10;
                $paginated = $query->paginate($perPage);

                return response()->json([
                    'status'       => 'success',
                    'data'         => $paginated->items(),
                    'current_page' => $paginated->currentPage(),
                    'last_page'    => $paginated->lastPage(),
                    'per_page'     => $paginated->perPage(),
                    'total'        => $paginated->total(),
                    'from'         => $paginated->firstItem() ?? 0,
                    'to'           => $paginated->lastItem() ?? 0,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'data'    => [],
                    'total'   => 0,
                ], 500);
            }
        }

        return $this->render('admin.pages.reports.sms-live-panel');
    }

    public function userDetails(Request $request)
    {
        try {
            $query = User::with(['package', 'userType', 'balanceSheet'])->orderBy('id', 'desc');

            if ($request->filled('user_name')) {
                $userName = $request->user_name;
                $query->where(function($q) use ($userName) {
                    $q->where('fname', 'like', '%' . $userName . '%')
                      ->orWhere('lname', 'like', '%' . $userName . '%')
                      ->orWhere('company_name', 'like', '%' . $userName . '%')
                      ->orWhere('regno', 'like', '%' . $userName . '%');
                });
            }

            if ($request->filled('contact_no')) {
                $contact = $request->contact_no;
                $query->where(function($q) use ($contact) {
                    $q->where('phone', 'like', '%' . $contact . '%')
                      ->orWhere('email', 'like', '%' . $contact . '%');
                });
            }

            if ($request->filled('from_date')) {
                $fromDate = $request->from_date;
                $query->where(function($q) use ($fromDate) {
                    $q->whereDate('regst_date', '>=', $fromDate)
                      ->orWhereDate('insert_date', '>=', $fromDate);
                });
            }

            if ($request->filled('to_date')) {
                $toDate = $request->to_date;
                $query->where(function($q) use ($toDate) {
                    $q->whereDate('regst_date', '<=', $toDate)
                      ->orWhereDate('insert_date', '<=', $toDate);
                });
            }

            if ($request->filled('quick_search')) {
                $search = $request->quick_search;
                $query->where(function($q) use ($search) {
                    $q->where('fname', 'like', '%' . $search . '%')
                      ->orWhere('lname', 'like', '%' . $search . '%')
                      ->orWhere('regno', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('company_name', 'like', '%' . $search . '%');
                });
            }

            // ── Dynamic CSV Export ──
            if ($request->get('export') === 'csv') {
                $users = $query->get();
                $filename = 'user-details-' . date('Y-m-d_His') . '.csv';

                $headers = [
                    'Content-Type'        => 'text/csv; charset=UTF-8',
                    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                    'Pragma'              => 'no-cache',
                    'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                    'Expires'             => '0',
                ];

                $callback = function () use ($users) {
                    $file = fopen('php://output', 'w');
                    // Add UTF-8 BOM for Excel compatibility
                    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                    
                    fputcsv($file, [
                        '#',
                        'REG NO',
                        'USER NAME',
                        'USER TYPE',
                        'COMPANY NAME',
                        'CONTACT NUMBER',
                        'EMAIL ID',
                        'PACKAGE NAME',
                        'TOTAL BALANCE',
                        'ADDRESS',
                        'PIN CODE',
                        'PAN NO',
                        'GST NUMBER',
                        'AADHAAR NUMBER',
                        'IS OTP VERIFY',
                        'OTP VERIFY TYPE',
                        'USER ID',
                        'IP ADDRESS',
                        'CALLBACK URL',
                        'STATUS',
                        'REG DATE',
                    ]);

                    foreach ($users as $index => $u) {
                        $fullName = trim(($u->fname ?? '') . ' ' . ($u->lname ?? ''));
                        $userType = $u->userType->user_name ?? ($u->catid ? 'TYPE ' . $u->catid : 'API USER');
                        $packageName = $u->package->pack_name ?? ($u->package_id ? 'PLAN #' . $u->package_id : '-');
                        $totalBalance = $u->balanceSheet->balance_amt ?? $u->balanceSheet->total_amt_for_prepaid ?? $u->regamt ?? '0.00';
                        $statusStr = in_array(strtoupper((string)$u->status), ['1', 'ACTIVE']) ? 'ACTIVE' : 'INACTIVE';
                        $isOtp = in_array(strtoupper((string)$u->isotpverify), ['1', 'YES']) ? 'YES' : 'NO';

                        fputcsv($file, [
                            $index + 1,
                            $u->regno ?? '',
                            $fullName,
                            $userType,
                            $u->company_name ?? '',
                            $u->phone ?? '',
                            $u->email ?? '',
                            $packageName,
                            number_format((float)$totalBalance, 2, '.', ''),
                            $u->addsdt ?? '',
                            $u->pincode ?? '',
                            $u->panno ?? '',
                            $u->gstnumber ?? '',
                            $u->aadharno ?? '',
                            $isOtp,
                            $u->otpverifytype ?? 'SMS',
                            $u->userid ?? ('USR' . ($u->regno ?? '')),
                            $u->ipaddress ?? '',
                            $u->callbackurl ?? '',
                            $statusStr,
                            $u->regst_date ?? $u->insert_date ?? '',
                        ]);
                    }
                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            }

            // ── Dynamic Printable View ──
            if ($request->get('print') === '1') {
                $users = $query->get();
                return view('admin.pages.reports.user-details-print', [
                    'users'    => $users,
                    'filters'  => $request->all(),
                ]);
            }

            // ── AJAX JSON Pagination ──
            if ($request->ajax() || $request->wantsJson()) {
                $perPage = 10;
                $paginated = $query->paginate($perPage);

                return response()->json([
                    'status' => 'success',
                    'data' => $paginated->items(),
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                    'from' => $paginated->firstItem() ?? 0,
                    'to' => $paginated->lastItem() ?? 0,
                ]);
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => [],
                    'total' => 0,
                ], 500);
            }
        }

        return $this->render('admin.pages.reports.user-details');
    }

    public function fundTransferReport(Request $request)
    {
        try {
            $query = FundTransfer::with(['user', 'walletType'])
                ->where('tnuserid', '0')
                ->orderBy('id', 'desc');

            if ($request->filled('company_name')) {
                $company = $request->company_name;
                $query->whereHas('user', function($q) use ($company) {
                    $q->where('company_name', 'like', '%' . $company . '%');
                });
            }

            if ($request->filled('user_name')) {
                $userName = $request->user_name;
                $query->whereHas('user', function($q) use ($userName) {
                    $q->where('fname', 'like', '%' . $userName . '%')
                      ->orWhere('lname', 'like', '%' . $userName . '%');
                });
            }

            if ($request->filled('reg_no')) {
                $query->where('regno', 'like', '%' . $request->reg_no . '%');
            }

            if ($request->filled('trans_desc')) {
                $query->where('transdesc', 'like', '%' . $request->trans_desc . '%');
            }

            if ($request->filled('from_date')) {
                $query->whereDate('trans_date', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('trans_date', '<=', $request->to_date);
            }

            // ── Dynamic CSV Export ──
            if ($request->get('export') === 'csv') {
                $transfers = $query->get();
                $filename = 'fund-transfer-report-' . date('Y-m-d_His') . '.csv';

                $headers = [
                    'Content-Type'        => 'text/csv; charset=UTF-8',
                    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                    'Pragma'              => 'no-cache',
                    'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                    'Expires'             => '0',
                ];

                $callback = function () use ($transfers) {
                    $file = fopen('php://output', 'w');
                    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                    fputcsv($file, [
                        '#',
                        'REG NO',
                        'COMPANY NAME',
                        'USER NAME',
                        'REQUEST TYPE',
                        'TRANSFER TYPE',
                        'TRANSFER AMOUNT',
                        'OPENING BALANCE',
                        'CLOSING BALANCE',
                        'WALLET TYPE',
                        'TRANSACTION DESC',
                        'TRANSACTION ID',
                        'TRANSACTION DATE/TIME',
                        'REQUEST ID',
                        'INSERT DATE',
                    ]);

                    foreach ($transfers as $index => $t) {
                        $company = $t->user->company_name ?? '-';
                        $userName = trim(($t->user->fname ?? '') . ' ' . ($t->user->lname ?? ''));
                        $reqType = (string)$t->reqtype === '0' ? 'BY ADMIN' : 'BY USER';
                        $transType = (string)$t->transfertype === '1' ? 'FUND TRANSFER' : 'FUND REVERSE';
                        $walletType = $t->walletType->typename ?? ($t->wallet_type_id == 1 ? 'PREPAID BALANCE' : '-');
                        $transDateTime = ($t->trans_date ? date('d/m/Y', strtotime($t->trans_date)) : '') . ' ' . ($t->trans_time ?? '');

                        fputcsv($file, [
                            $index + 1,
                            $t->regno ?? '',
                            $company,
                            $userName,
                            $reqType,
                            $transType,
                            number_format((float)$t->transfer_amt, 2, '.', ''),
                            number_format((float)$t->opening_bal, 2, '.', ''),
                            number_format((float)$t->closing_bal, 2, '.', ''),
                            $walletType,
                            $t->transdesc ?: '-',
                            $t->online_tranid ?: '-',
                            trim($transDateTime) ?: '-',
                            $t->request_id ?: '-',
                            $t->insert_date ?? '',
                        ]);
                    }
                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            }

            // ── Dynamic Printable View ──
            if ($request->get('print') === '1') {
                $transfers = $query->get();
                $prepaidTotal = (clone $query)->where('wallet_type_id', 1)->sum('transfer_amt');
                $utilityTotal = (clone $query)->where('wallet_type_id', 2)->sum('transfer_amt');
                $bankTotal    = (clone $query)->where('wallet_type_id', 3)->sum('transfer_amt');
                $grandTotal   = (clone $query)->sum('transfer_amt');

                return view('admin.pages.reports.fund-transfer-print', [
                    'transfers'    => $transfers,
                    'filters'      => $request->all(),
                    'prepaidTotal' => $prepaidTotal,
                    'utilityTotal' => $utilityTotal,
                    'bankTotal'    => $bankTotal,
                    'grandTotal'   => $grandTotal,
                ]);
            }

            // ── AJAX JSON Pagination (Limit 20) ──
            if ($request->ajax() || $request->wantsJson()) {
                $perPage = 20;
                $paginated = $query->paginate($perPage);

                // Summary Totals
                $prepaidTotal = (clone $query)->where('wallet_type_id', 1)->sum('transfer_amt');
                $utilityTotal = (clone $query)->where('wallet_type_id', 2)->sum('transfer_amt');
                $bankTotal    = (clone $query)->where('wallet_type_id', 3)->sum('transfer_amt');
                $grandTotal   = (clone $query)->sum('transfer_amt');

                return response()->json([
                    'status'        => 'success',
                    'data'          => $paginated->items(),
                    'current_page'  => $paginated->currentPage(),
                    'last_page'     => $paginated->lastPage(),
                    'per_page'      => $paginated->perPage(),
                    'total'         => $paginated->total(),
                    'from'          => $paginated->firstItem() ?? 0,
                    'to'            => $paginated->lastItem() ?? 0,
                    'summary'       => [
                        'prepaid' => number_format((float)$prepaidTotal, 2, '.', ''),
                        'utility' => number_format((float)$utilityTotal, 2, '.', ''),
                        'bank'    => number_format((float)$bankTotal, 2, '.', ''),
                        'grand'   => number_format((float)$grandTotal, 2, '.', ''),
                    ]
                ]);
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'data'    => [],
                    'total'   => 0,
                ], 500);
            }
        }

        return $this->render('admin.pages.reports.fund-transfer-report');
    }

    public function allUserLedger(Request $request)
    {
        try {
            $query = User::with(['package', 'userType', 'balanceSheet'])
                ->has('balanceSheet')
                ->orderBy('id', 'asc');

            if ($request->filled('company_name')) {
                $query->where('company_name', 'like', '%' . $request->company_name . '%');
            }

            if ($request->filled('user_name')) {
                $userName = $request->user_name;
                $query->where(function($q) use ($userName) {
                    $q->where('fname', 'like', '%' . $userName . '%')
                      ->orWhere('lname', 'like', '%' . $userName . '%');
                });
            }

            if ($request->filled('reg_no')) {
                $query->where('regno', 'like', '%' . $request->reg_no . '%');
            }

            if ($request->filled('contact_no')) {
                $query->where('phone', 'like', '%' . $request->contact_no . '%');
            }

            if ($request->filled('from_date')) {
                $query->whereDate('regst_date', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('regst_date', '<=', $request->to_date);
            }

            // ── Dynamic CSV Export ──
            if ($request->get('export') === 'csv') {
                $users = $query->get();
                $filename = 'all-user-ledger-report-' . date('Y-m-d_His') . '.csv';

                $headers = [
                    'Content-Type'        => 'text/csv; charset=UTF-8',
                    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                    'Pragma'              => 'no-cache',
                    'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                    'Expires'             => '0',
                ];

                $callback = function () use ($users) {
                    $file = fopen('php://output', 'w');
                    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                    fputcsv($file, [
                        '#',
                        'REGNO',
                        'USER NAME',
                        'COMPANY NAME',
                        'USER CATEGORY',
                        'CONTACT NO',
                        'PACKAGE NAME',
                        'CREDIT AMT',
                        'DEBIT AMT',
                        'COMM AMT',
                        'BALANCE',
                    ]);

                    foreach ($users as $index => $u) {
                        $b = $u->balanceSheet;
                        $debitAmt = $b ? (float)($b->instamt_for_prepaid + $b->instamt_for_utility + $b->instamt_for_bank + $b->instamt_for_travel) : 0;
                        $creditAmt = $b ? (float)($b->service_amt_for_prepaid + $b->service_amt_for_utility + $b->service_amt_for_bank + $b->service_amt_for_travel) : 0;
                        $commAmt = $b ? (float)($b->comamt_for_prepaid) : 0;
                        $balanceAmt = $b ? (float)($b->balance_amt) : 0;

                        fputcsv($file, [
                            $index + 1,
                            $u->regno ?? '',
                            trim(($u->fname ?? '') . ' ' . ($u->lname ?? '')),
                            $u->company_name ?? '-',
                            $u->userType->user_type ?? $u->catid ?? '-',
                            $u->phone ?? '-',
                            $u->package->pack_name ?? '-',
                            number_format($debitAmt, 2, '.', ''),
                            number_format($creditAmt, 2, '.', ''),
                            number_format($commAmt, 2, '.', ''),
                            number_format($balanceAmt, 2, '.', ''),
                        ]);
                    }
                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            }

            // ── Dynamic Printable View ──
            if ($request->get('print') === '1') {
                $users = $query->get();

                $totDebit = 0; $totCredit = 0; $totComm = 0; $totBalance = 0;
                foreach ($users as $u) {
                    $b = $u->balanceSheet;
                    if ($b) {
                        $totDebit += (float)($b->instamt_for_prepaid + $b->instamt_for_utility + $b->instamt_for_bank + $b->instamt_for_travel);
                        $totCredit += (float)($b->service_amt_for_prepaid + $b->service_amt_for_utility + $b->service_amt_for_bank + $b->service_amt_for_travel);
                        $totComm += (float)($b->comamt_for_prepaid);
                        $totBalance += (float)($b->balance_amt);
                    }
                }

                return view('admin.pages.reports.all-user-ledger-print', [
                    'users'      => $users,
                    'filters'    => $request->all(),
                    'totDebit'   => $totDebit,
                    'totCredit'  => $totCredit,
                    'totComm'    => $totComm,
                    'totBalance' => $totBalance,
                ]);
            }

            // ── AJAX JSON Pagination (Limit 20) ──
            if ($request->ajax() || $request->wantsJson()) {
                $perPage = 10;
                $paginated = $query->paginate($perPage);

                // Summary Totals for active filtered dataset
                $balanceSums = DB::table('b1_api_user_reg_tbl as a')
                    ->join('b4_api_user_balance_sheet_tbl as c', 'a.regno', '=', 'c.uregno')
                    ->when($request->filled('company_name'), fn($q) => $q->where('a.company_name', 'like', '%' . $request->company_name . '%'))
                    ->when($request->filled('user_name'), fn($q) => $q->where(fn($uq) => $uq->where('a.fname', 'like', '%' . $request->user_name . '%')->orWhere('a.lname', 'like', '%' . $request->user_name . '%')))
                    ->when($request->filled('reg_no'), fn($q) => $q->where('a.regno', 'like', '%' . $request->reg_no . '%'))
                    ->when($request->filled('contact_no'), fn($q) => $q->where('a.phone', 'like', '%' . $request->contact_no . '%'))
                    ->selectRaw("
                        SUM(COALESCE(c.instamt_for_prepaid, 0) + COALESCE(c.instamt_for_utility, 0) + COALESCE(c.instamt_for_bank, 0) + COALESCE(c.instamt_for_travel, 0)) as tot_debit,
                        SUM(COALESCE(c.service_amt_for_prepaid, 0) + COALESCE(c.service_amt_for_utility, 0) + COALESCE(c.service_amt_for_bank, 0) + COALESCE(c.service_amt_for_travel, 0)) as tot_credit,
                        SUM(COALESCE(c.comamt_for_prepaid, 0)) as tot_comm,
                        SUM(COALESCE(c.balance_amt, 0)) as tot_balance
                    ")->first();

                // Format row items
                $items = collect($paginated->items())->map(function($u) {
                    $b = $u->balanceSheet;
                    return [
                        'id'           => $u->id,
                        'regno'        => $u->regno,
                        'fname'        => $u->fname,
                        'lname'        => $u->lname,
                        'company_name' => $u->company_name,
                        'catid'        => $u->userType->user_type ?? $u->catid ?? '-',
                        'phone'        => $u->phone,
                        'pack_name'    => $u->package->pack_name ?? '-',
                        'debit_amt'    => $b ? number_format((float)($b->instamt_for_prepaid + $b->instamt_for_utility + $b->instamt_for_bank + $b->instamt_for_travel), 2, '.', '') : '0.00',
                        'credit_amt'   => $b ? number_format((float)($b->service_amt_for_prepaid + $b->service_amt_for_utility + $b->service_amt_for_bank + $b->service_amt_for_travel), 2, '.', '') : '0.00',
                        'comm_amt'     => $b ? number_format((float)$b->comamt_for_prepaid, 2, '.', '') : '0.00',
                        'balance_amt'  => $b ? number_format((float)$b->balance_amt, 2, '.', '') : '0.00',
                    ];
                });

                return response()->json([
                    'status'        => 'success',
                    'data'          => $items,
                    'current_page'  => $paginated->currentPage(),
                    'last_page'     => $paginated->lastPage(),
                    'per_page'      => $paginated->perPage(),
                    'total'         => $paginated->total(),
                    'from'          => $paginated->firstItem() ?? 0,
                    'to'            => $paginated->lastItem() ?? 0,
                    'summary'       => [
                        'tot_debit'   => number_format((float)($balanceSums->tot_debit ?? 0), 2, '.', ''),
                        'tot_credit'  => number_format((float)($balanceSums->tot_credit ?? 0), 2, '.', ''),
                        'tot_comm'    => number_format((float)($balanceSums->tot_comm ?? 0), 2, '.', ''),
                        'tot_balance' => number_format((float)($balanceSums->tot_balance ?? 0), 2, '.', ''),
                    ]
                ]);
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'data'    => [],
                    'total'   => 0,
                ], 500);
            }
        }

        return $this->render('admin.pages.reports.all-user-ledger');
    }

    public function userLedgerDetails(Request $request)
    {
        try {
            $regno = $request->input('regno');
            $query = UserTranLazer::where('regno', $regno)->orderBy('id', 'desc');

            if ($request->filled('brandtext')) {
                $query->where('transdesc', 'like', '%' . $request->brandtext . '%');
            }

            $perPage = 20;
            $paginated = $query->paginate($perPage);

            return response()->json([
                'status'       => 'success',
                'data'         => $paginated->items(),
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
                'per_page'     => $paginated->perPage(),
                'total'        => $paginated->total(),
                'from'         => $paginated->firstItem() ?? 0,
                'to'           => $paginated->lastItem() ?? 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'data'    => [],
                'total'   => 0,
            ], 500);
        }
    }

    public function userWiseLedger()
    {
        return $this->render('admin.pages.reports.user-wise-ledger');
    }
}
