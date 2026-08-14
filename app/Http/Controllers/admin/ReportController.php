<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function smsDetails()
    {
        return $this->render('admin.pages.reports.sms-details');
    }

    public function smsLivePanel()
    {
        return $this->render('admin.pages.reports.sms-live-panel');
    }

    public function userDetails()
    {
        return $this->render('admin.pages.reports.user-details');
    }

    public function fundTransferReport()
    {
        return $this->render('admin.pages.reports.fund-transfer-report');
    }

    public function allUserLedger()
    {
        return $this->render('admin.pages.reports.all-user-ledger');
    }

    public function userWiseLedger()
    {
        return $this->render('admin.pages.reports.user-wise-ledger');
    }
}
