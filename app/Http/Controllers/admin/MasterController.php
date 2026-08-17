<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function companySetup()
    {
        return $this->render('admin.pages.master.company-setup');
    }

    public function adminRegister()
    {
      
        return $this->render('admin.pages.master.admin-register');
    }

    public function userRegister()
    {
        return $this->render('admin.pages.master.user-register');
    }
}
