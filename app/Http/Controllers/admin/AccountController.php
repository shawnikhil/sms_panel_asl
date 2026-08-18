<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AccountController extends Controller
{
    /**
     * View Add Bank Page
     */
    public function addBank()
    {
        $banks = Bank::orderBy('id', 'desc')->get();

        return view('admin.pages.account.add-bank', [
            'user'  => Auth::user(),
            'banks' => $banks,
        ]);
    }

    /**
     * Handle Bank Action (Create, Update & Delete)
     */
    public function handleBankAction(Request $request)
    {
        $now = Carbon::now();
        $logUser = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';

        // ── 1. Delete Action ──
        $delId = $request->input('delid') ?? ($request->input('action') === 'delete' ? $request->input('bank_id') : null);
        if (!empty($delId)) {
            $bank = Bank::find($delId);
            if ($bank) {
                $bank->delete();
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Bank account deleted successfully.',
                ]);
            }
            return response()->json([
                'status'  => 'error',
                'message' => 'Bank record not found to delete.',
            ], 404);
        }

        // ── 2. Create / Update Action ──
        $bankName  = trim((string)$request->input('bank_name', ''));
        $accNo     = trim((string)$request->input('accno', $request->input('account_number', '')));
        $ifscCode  = strtoupper(trim((string)$request->input('ifsc_code', '')));
        $branchName= trim((string)$request->input('branc_name', $request->input('branch_name', '')));
        $status    = $request->input('status', '1');
        $editId    = $request->input('editid') ?? $request->input('bank_id');

        if (empty($bankName)) {
            return response()->json(['status' => 'error', 'message' => 'Please enter Bank Name!'], 422);
        }
        if (empty($accNo)) {
            return response()->json(['status' => 'error', 'message' => 'Please enter Account Number!'], 422);
        }
        if (!preg_match('/^\d{9,18}$/', $accNo)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Bank Account Number! Must be 9 to 18 numeric digits.'], 422);
        }
        if (empty($ifscCode)) {
            return response()->json(['status' => 'error', 'message' => 'Please enter IFSC Code!'], 422);
        }
        if (!preg_match('/^[A-Z]{4}0[A-Z0-9]{6}$/', $ifscCode)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Indian IFSC Code format! (e.g. SBIN0001234, HDFC0000128)'], 422);
        }

        // Duplicate Account Number Check
        $exists = Bank::where('accno', $accNo)
            ->when($editId, fn($q) => $q->where('id', '<>', $editId))
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Bank Account Number already registered!',
            ], 422);
        }

        $statusVal = in_array(strtoupper((string)$status), ['1', 'Y', 'YES', 'ACTIVE']) ? '1' : '0';

        $bankData = [
            'com_id'     => (int)($request->input('com_id', 1)),
            'bank_name'  => $bankName,
            'branc_name' => $branchName,
            'accno'      => $accNo,
            'ifsc_code'  => $ifscCode,
            'status'     => $statusVal,
        ];

        // ── CREATE NEW BANK RECORD ──
        if (empty($editId)) {
            $bank = Bank::create(array_merge($bankData, [
                'insert_date' => $now->format('Y-m-d H:i:s'),
                'insert_user' => $logUser,
            ]));

            return response()->json([
                'status'  => 'success',
                'message' => 'Bank account added successfully!',
                'bank'    => $bank,
            ]);
        }

        // ── UPDATE EXISTING BANK RECORD ──
        $bank = Bank::findOrFail($editId);
        $bank->update(array_merge($bankData, [
            'update_date' => $now->format('Y-m-d H:i:s'),
            'update_user' => $logUser,
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Bank account updated successfully!',
            'bank'    => $bank->fresh(),
        ]);
    }

    /**
     * View Fund Transfer Page
     */
    public function fundTransfer()
    {
        $apiUsers = DB::table('b1_api_user_reg_tbl as a')
            ->join('b4_api_user_balance_sheet_tbl as b', 'a.regno', '=', 'b.uregno')
            ->select('a.regno', 'a.fname', 'a.lname', 'a.phone', 'a.company_name', 'b.balance_amt')
            ->orderBy('a.fname', 'asc')
            ->orderBy('a.lname', 'asc')
            ->get();

        $walletTypes = DB::table('x_api_wallet_type_tbl')
            ->orderBy('id', 'asc')
            ->get();

        // Recent transfers for Modal Table
        $transfers = collect();
        if (Schema::hasTable('b2_api_user_fund_transfer_tbl')) {
            $transfers = DB::table('b2_api_user_fund_transfer_tbl as ft')
                ->leftJoin('b1_api_user_reg_tbl as u', 'ft.regno', '=', 'u.regno')
                ->leftJoin('x_api_wallet_type_tbl as wt', 'ft.wallet_type_id', '=', 'wt.id')
                ->select(
                    'ft.*',
                    'u.fname',
                    'u.lname',
                    'u.company_name',
                    'wt.typename as wallet_name'
                )
                ->orderBy('ft.id', 'desc')
                ->limit(100)
                ->get();
        }

        return view('admin.pages.account.fund-transfer', [
            'user'        => Auth::user(),
            'apiUsers'    => $apiUsers,
            'walletTypes' => $walletTypes,
            'transfers'   => $transfers,
        ]);
    }

    /**
     * Handle Fund Transfer Action (Legacy logic matching option 119)
     */
    public function handleFundTransferAction(Request $request)
    {
        $logUser = Auth::user()->admin_username ?? Auth::user()->name ?? 'admin';
        $curdate = Carbon::now()->format('Y-m-d');
        $ttime   = Carbon::now()->format('h:i:s A');

        $apiuser    = trim((string)$request->input('apiuser', $request->input('api_user', '')));
        $transid    = (string)$request->input('transid', $request->input('transfer_type', '1'));
        $tranamt    = (float)trim((string)$request->input('tranamt', $request->input('amount', 0)));
        $wallettype = (int)$request->input('wallettype', $request->input('wallet_type', 1));
        $transdesc  = trim((string)$request->input('transdesc', $request->input('transaction_desc', '')));
        $trandate   = trim((string)$request->input('trandate', $request->input('transaction_date', $curdate)));

        // Handle date formats
        if (str_contains($trandate, '/')) {
            $d = explode('/', $trandate);
            if (count($d) === 3) {
                $trandate = $d[2] . '-' . $d[1] . '-' . $d[0];
            }
        }
        if (empty($trandate)) {
            $trandate = $curdate;
        }

        // Validation
        if (empty($apiuser)) {
            return response()->json(['status' => 'error', 'field' => 'apiuser', 'message' => 'Please select user name !'], 422);
        }
        if ($transid === '') {
            return response()->json(['status' => 'error', 'field' => 'transid', 'message' => 'Please select transaction type !'], 422);
        }
        if ($tranamt <= 0) {
            return response()->json(['status' => 'error', 'field' => 'tranamt', 'message' => 'Please enter transfer amount !'], 422);
        }
        if (empty($wallettype)) {
            return response()->json(['status' => 'error', 'field' => 'wallettype', 'message' => 'Please select wallet !'], 422);
        }
        if (empty($trandate)) {
            return response()->json(['status' => 'error', 'field' => 'trandate', 'message' => 'Please enter transaction date !'], 422);
        }

        try {
            $transferRecord = DB::transaction(function () use ($apiuser, $transid, $tranamt, $wallettype, $transdesc, $trandate, $curdate, $ttime, $logUser) {
                // 1. Fetch User Opening Balance
                $balanceSheet = DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->first();
                $openbal = $balanceSheet ? (float)$balanceSheet->balance_amt : 0.0;

                $debitamt = $tranamt;
                $signedAmt = ($transid === '0') ? (-$tranamt) : $tranamt;
                $closingbal = $openbal + $signedAmt;

                // 2. Insert into b2_api_user_fund_transfer_tbl
                $transferId = null;
                if (Schema::hasTable('b2_api_user_fund_transfer_tbl')) {
                    $transferId = DB::table('b2_api_user_fund_transfer_tbl')->insertGetId([
                        'regno'          => $apiuser,
                        'transfertype'   => $transid,
                        'transfer_amt'   => $signedAmt,
                        'wallet_type_id' => $wallettype,
                        'transdesc'      => $transdesc,
                        'trans_date'     => $trandate,
                        'trans_time'     => $ttime,
                        'opening_bal'    => $openbal,
                        'closing_bal'    => $closingbal,
                        'status'         => '1',
                        'insert_date'    => $curdate,
                        'insert_user'    => $logUser,
                    ]);
                }

                // 3. Insert into Ledger b4_api_user_tran_lazer_tbl
                if (Schema::hasTable('b4_api_user_tran_lazer_tbl')) {
                    $lazerDesc = ($transid === '1') ? 'FUND TRANSFER (DIRECT)' : 'FUND REVERSE (DIRECT)';
                    DB::table('b4_api_user_tran_lazer_tbl')->insert([
                        'regno'       => $apiuser,
                        'transdesc'   => $lazerDesc,
                        'trans_date'  => $curdate,
                        'trans_time'  => $ttime,
                        'credit_amt'  => ($transid === '1') ? $tranamt : 0,
                        'debit_amt'   => ($transid === '0') ? $debitamt : 0,
                        'opening_bal' => $openbal,
                        'closing_bal' => $closingbal,
                        'status'      => '1',
                        'insert_date' => $curdate,
                        'insert_user' => $logUser,
                    ]);
                }

                // 4. Update b4_api_user_balance_sheet_tbl by Wallet Type (Exact Legacy Sequence)
                $addamt = $signedAmt;
                if (Schema::hasTable('b4_api_user_balance_sheet_tbl')) {
                    if ($wallettype == 1) {
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'instamt_for_prepaid' => DB::raw("instamt_for_prepaid + ($addamt)"),
                        ]);
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'total_amt_for_prepaid' => DB::raw("((instamt_for_prepaid + comamt_for_prepaid) - service_amt_for_prepaid)"),
                        ]);
                    } elseif ($wallettype == 2) {
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'instamt_for_utility' => DB::raw("instamt_for_utility + ($addamt)"),
                        ]);
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'total_amt_for_utility' => DB::raw("((instamt_for_utility + comamt_for_utility) - service_amt_for_utility)"),
                        ]);
                    } elseif ($wallettype == 3) {
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'instamt_for_bank' => DB::raw("instamt_for_bank + ($addamt)"),
                        ]);
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'total_amt_for_bank' => DB::raw("((instamt_for_bank + comamt_for_bank) - service_amt_for_bank)"),
                        ]);
                    } elseif ($wallettype == 4) {
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'instamt_for_travel' => DB::raw("instamt_for_travel + ($addamt)"),
                        ]);
                        DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                            'total_amt_for_travel' => DB::raw("((instamt_for_travel + comamt_for_travel) - service_amt_for_travel)"),
                        ]);
                    }

                    // Update total balance
                    DB::table('b4_api_user_balance_sheet_tbl')->where('uregno', $apiuser)->update([
                        'balance_amt' => DB::raw("(total_amt_for_prepaid + total_amt_for_utility + total_amt_for_bank + total_amt_for_travel)"),
                        'update_date' => $curdate,
                        'update_user' => $logUser,
                    ]);
                }

                // 5. Update f1_admin_balance_sheet_tbl if table exists (Exact Legacy Sequence)
                if (Schema::hasTable('f1_admin_balance_sheet_tbl')) {
                    try {
                        if ($wallettype == 1) {
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'service_amt_for_prepaid' => DB::raw("service_amt_for_prepaid + ($addamt)"),
                            ]);
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'total_amt_for_prepaid'   => DB::raw("((instamt_for_prepaid - service_amt_for_prepaid) + comamt_for_prepaid)"),
                            ]);
                        } elseif ($wallettype == 2) {
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'service_amt_for_utility' => DB::raw("service_amt_for_utility + ($addamt)"),
                            ]);
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'total_amt_for_utility'   => DB::raw("((instamt_for_utility - service_amt_for_utility) + comamt_for_utility)"),
                            ]);
                        } elseif ($wallettype == 3) {
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'service_amt_for_bank' => DB::raw("service_amt_for_bank + ($addamt)"),
                            ]);
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'total_amt_for_bank'   => DB::raw("((instamt_for_bank - service_amt_for_bank) + comamt_for_bank)"),
                            ]);
                        } elseif ($wallettype == 4) {
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'service_amt_for_travel' => DB::raw("service_amt_for_travel + ($addamt)"),
                            ]);
                            DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                                'total_amt_for_travel'   => DB::raw("((instamt_for_travel - service_amt_for_travel) + comamt_for_travel)"),
                            ]);
                        }

                        DB::table('f1_admin_balance_sheet_tbl')->where('id', '>=', 1)->update([
                            'balance_amt' => DB::raw("(total_amt_for_prepaid + total_amt_for_utility + total_amt_for_bank + total_amt_for_travel)"),
                            'update_date' => $curdate,
                            'update_user' => $logUser,
                        ]);
                    } catch (\Exception $e) {}
                }

                // Return payload info
                $userInfo = DB::table('b1_api_user_reg_tbl')->where('regno', $apiuser)->first();
                return [
                    'id'          => $transferId,
                    'tran_id'     => $transferId,
                    'reg_no'      => $apiuser,
                    'user'        => trim(($userInfo->fname ?? '') . ' ' . ($userInfo->lname ?? '')),
                    'company'     => $userInfo->company_name ?? 'ASL WALLETS',
                    'type'        => ($transid === '1') ? 'FUND TRANSFER' : 'FUND REVERSE',
                    'amount'      => number_format($tranamt, 2, '.', ''),
                    'wallet'      => ($wallettype == 1 ? 'PREPAID BALANCE' : ($wallettype == 2 ? 'UTILITY BALANCE' : ($wallettype == 3 ? 'BANK WALLET' : 'TRAVEL BALANCE'))),
                    'open_bal'    => number_format($openbal, 2, '.', ''),
                    'close_bal'   => number_format($closingbal, 2, '.', ''),
                    'closing_bal_raw' => $closingbal,
                    'transdesc'   => $transdesc ?: '-',
                    'trans_datetime' => $trandate . ' ' . $ttime,
                    'insert_date' => $curdate,
                ];
            });

            return response()->json([
                'status'   => 'success',
                'errmsg'   => 1,
                'message'  => ($transid === '1' ? 'Fund transferred successfully!' : 'Fund reversed successfully!'),
                'transfer' => $transferRecord,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'errmsg'  => 0,
                'message' => 'Error! While fund transfer : ' . $e->getMessage(),
            ], 500);
        }
    }
}
