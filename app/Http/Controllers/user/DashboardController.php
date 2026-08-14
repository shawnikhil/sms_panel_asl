<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
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
        return $this->render('user.layout.index');
    }

    public function sendSms()
    {
        return $this->render('user.layout.send-sms');
    }

    public function campaigns()
    {
        return $this->render('user.layout.campaigns');
    }

    public function contacts()
    {
        return $this->render('user.layout.contacts');
    }

    public function senderIds()
    {
        return $this->render('user.layout.sender-ids');
    }

    public function deliverySummary()
    {
        return $this->render('user.layout.delivery-summary');
    }

    public function billingHistory()
    {
        return $this->render('user.layout.billing-history');
    }

    public function apiUsage()
    {
        return $this->render('user.layout.api-usage');
    }

    public function profile()
    {
        return $this->render('user.layout.profile');
    }

    public function apiKeys()
    {
        return $this->render('user.layout.api-keys');
    }

    public function security()
    {
        return $this->render('user.layout.security');
    }

    public function helpCenter()
    {
        return $this->render('user.layout.help-center');
    }
}



