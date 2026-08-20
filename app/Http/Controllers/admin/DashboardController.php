<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ApiTransactionDetail;
use App\Models\BalanceSheet;
use App\Models\FundTransfer;
use App\Models\SmsApi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

        // 1. Dynamic SMS Stats
        $todaySms = ApiTransactionDetail::where('trandate', $today)->count();
        $totalSms = ApiTransactionDetail::count();

        // 2. Success Rate
        $totalSuccess = ApiTransactionDetail::where('status', '1')->count();
        $successRate = $totalSms > 0 ? round(($totalSuccess / $totalSms) * 100, 2) : 100;

        // 3. Client Accounts
        $totalUsers = User::count();
        $activeUsers = User::where('status', '1')->count();

        // 4. Wallet in Circulation
        $totalWalletBalance = BalanceSheet::sum('balance_amt') ?? 0;

        // 5. Gateways
        $activeGateways = SmsApi::whereIn('status', ['1', 'ACTIVE', 'active', 'Y', 'YES'])->count();
        $totalGateways = SmsApi::count();

        // 6. Recent Live Transactions
        $recentTransactions = ApiTransactionDetail::with('user')->orderBy('id', 'desc')->limit(6)->get();

        return view('admin.dashboard', [
            'user'               => Auth::user(),
            'todaySms'           => $todaySms,
            'totalSms'           => $totalSms,
            'successRate'        => $successRate,
            'totalUsers'         => $totalUsers,
            'activeUsers'        => $activeUsers,
            'totalWalletBalance' => $totalWalletBalance,
            'activeGateways'     => $activeGateways,
            'totalGateways'      => $totalGateways,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}



