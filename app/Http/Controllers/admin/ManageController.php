<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function senderId()
    {
        return $this->render('admin.pages.manage.manage-sender-id');
    }

    public function template()
    {
        return $this->render('admin.pages.manage.manage-template');
    }
}
