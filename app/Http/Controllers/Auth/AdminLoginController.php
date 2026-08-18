<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-login');
    }

    public function login(Request $request)
    {

        
        $request->validate([
            'admin_username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['accepted'],
        ], [
            'admin_username.required' => 'Please enter your admin username.',
            'password.required' => 'Please enter your password.',
            'remember.accepted' => 'You must check "Remember this device" to login.',
        ]);

        $loginField = trim($request->input('admin_username'));
        $remember = $request->boolean('remember');

        if (! $remember) {
            return $this->jsonError($request, 'You must check "Remember this device" to login.', 'remember');
        }

        $admin = Admin::where('admin_username', $loginField)->first();

        if (! $admin) {
            return $this->jsonError($request, 'No admin account found for this username.', 'admin_username');
        }

        $status = (string) ($admin->status ?? '0');
        if (! in_array($status, ['1', 'active'], true)) {
            return $this->jsonError($request, 'Your account is inactive. Please contact support.', 'admin_username');
        }

        $providedPassword = (string) $request->input('password');
        $storedPassword   = (string) ($admin->admin_password ?? '');
        $isValidPassword  = false;

        if (! empty($storedPassword)) {
            $isValidPassword = Hash::check($providedPassword, $storedPassword)
                || $storedPassword === $providedPassword
                || $storedPassword === md5($providedPassword)
                || $storedPassword === sha1($providedPassword)
                || $storedPassword === base64_encode($providedPassword);
        }

        if (! $isValidPassword) {
            return $this->jsonError($request, 'The provided credentials are incorrect.', 'admin_username');
        }

        if ($this->requiresOtp($admin)) {
            $otp = $this->generateOtp(); // Returns default fixed '123456'
            $request->session()->put('admin_login_otp', Hash::make($otp));
            $request->session()->put('admin_login_username', $admin->admin_username);
            $request->session()->put('admin_login_remember', $remember);

            $payload = [
                'status' => false,
                'requires_otp' => true,
                'otp' => '123456',
                'message' => 'OTP verification required. Default OTP is 123456.',
            ];

            return $this->jsonResponse($request, $payload);
        }

        Auth::guard('admin')->login($admin, $remember);
        $request->session()->regenerate();

        return $this->jsonResponse($request, [
            'success' => true,
            'status' => true,
            'redirect' => route('admin.dashboard'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'admin_username' => ['required', 'string'],
            'otp' => ['required', 'digits:6'],
        ], [
            'admin_username.required' => 'Please enter your admin username.',
            'otp.required' => 'Please enter the OTP.',
            'otp.digits' => 'The OTP must be 6 digits.',
        ]);

        $submittedUsername = trim($request->input('admin_username'));
        $submittedOtp = trim($request->input('otp'));

        $admin = Admin::where('admin_username', $submittedUsername)->first();

        if (! $admin) {
            return $this->jsonError($request, 'No admin account found for this username.', 'admin_username');
        }

        $status = (string) ($admin->status ?? '0');
        if (! in_array($status, ['1', 'active'], true)) {
            return $this->jsonError($request, 'Your account is inactive. Please contact support.', 'admin_username');
        }

        $storedOtp = $request->session()->pull('admin_login_otp');
        $remember = $request->session()->pull('admin_login_remember', true);

        $isOtpValid = (! empty($storedOtp) && Hash::check($submittedOtp, $storedOtp)) || $submittedOtp === '123456';

        if (! $isOtpValid) {
            return $this->jsonError($request, 'The OTP you entered is incorrect.', 'otp');
        }

        Auth::guard('admin')->login($admin, $remember);
        $request->session()->regenerate();

        return $this->jsonResponse($request, [
            'success' => true,
            'status' => true,
            'redirect' => route('admin.dashboard'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function requiresOtp(Admin $admin): bool
    {
        return true;
    }

    private function generateOtp(): string
    {
        return '123456';
    }

    private function jsonResponse(Request $request, array $payload): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($payload);
        }

        if (! empty($payload['success'])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors($payload['errors'] ?? [])->withInput();
    }

    private function jsonError(Request $request, string $message, string $field = 'admin_username'): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => [$field => $message],
            ], 422);
        }

        return back()->withErrors([$field => $message])->onlyInput($field);
    }
}
