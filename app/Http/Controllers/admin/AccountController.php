<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function addBank()
    {
        return $this->render('admin.pages.account.add-bank');
    }

    public function fundTransfer()
    {
        return $this->render('admin.pages.account.fund-transfer');
    }
}
