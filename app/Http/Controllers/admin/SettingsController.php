<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function profile()
    {
        return $this->render('admin.pages.settings.profile');
    }

    public function apiKeys()
    {
        return $this->render('admin.pages.settings.api-keys');
    }

    public function security()
    {
        return $this->render('admin.pages.settings.security');
    }
}
