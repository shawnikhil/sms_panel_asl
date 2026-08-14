<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SchedulerController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function smsApi()
    {
        return $this->render('admin.pages.scheduler.sms-api');
    }
}
