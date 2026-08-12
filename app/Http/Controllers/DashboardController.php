<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function index()
    {
        return $this->render('user.dashboard.index');
    }

    public function sendSms()
    {
        return $this->render('user.dashboard.send-sms');
    }

    public function campaigns()
    {
        return $this->render('user.dashboard.campaigns');
    }

    public function contacts()
    {
        return $this->render('user.dashboard.contacts');
    }

    public function senderIds()
    {
        return $this->render('user.dashboard.sender-ids');
    }

    public function deliverySummary()
    {
        return $this->render('user.dashboard.delivery-summary');
    }

    public function billingHistory()
    {
        return $this->render('user.dashboard.billing-history');
    }

    public function apiUsage()
    {
        return $this->render('user.dashboard.api-usage');
    }

    public function profile()
    {
        return $this->render('user.dashboard.profile');
    }

    public function apiKeys()
    {
        return $this->render('user.dashboard.api-keys');
    }

    public function security()
    {
        return $this->render('user.dashboard.security');
    }

    public function helpCenter()
    {
        return $this->render('user.dashboard.help-center');
    }
}



