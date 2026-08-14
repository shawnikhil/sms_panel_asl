<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected function render(string $view)
    {
        return view($view, [
            'user' => Auth::user(),
        ]);
    }

    public function index()
    {
        return $this->render('admin.dashboard');
    }
}



