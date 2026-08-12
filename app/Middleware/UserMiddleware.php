<?php
namespace App\Middleware;

// app/Http/Middleware/UserMiddleware.php

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $status = (string) Auth::user()->status;

        if (! in_array($status, ['active', '1'], true)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive.');
        }

        return $next($request);
    }
}