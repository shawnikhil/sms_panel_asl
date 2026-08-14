<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function helpSetup()
    {
        return $this->render('admin.pages.help.help-setup');
    }

    public function notification()
    {
        return $this->render('admin.pages.help.notification');
    }
}
