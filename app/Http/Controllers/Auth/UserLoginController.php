<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.user-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'userid' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['required', 'in:on'],
        ], [
            'userid.required' => 'Please enter your user ID.',
            'password.required' => 'Please enter your password.',
            'remember.required' => 'Please check Remember Me to continue.',
            'remember.in' => 'Invalid Remember Me value.',
        ]);

        $loginField = trim($request->input('userid'));
        $remember = $request->boolean('remember');
        $user = User::where('userid', $loginField)
            ->where('regtype', 4)
            ->first();

        if (! $user) {
            return $this->jsonError($request, 'No account found for this user ID with regtype 4.', 'userid');
        }

        $status = (string) ($user->status ?? '0');
        if (! in_array($status, ['1', 'active'], true)) {
            return $this->jsonError($request, 'Your account is inactive. Please contact support.', 'userid');
        }

        $providedPassword = $request->input('password');
        $isValidPassword = false;

        if (! empty($user->userpass)) {
            $isValidPassword = Hash::check($providedPassword, $user->userpass);
        }

        if (! $isValidPassword) {
             
            return $this->jsonError($request, 'The provided credentials are incorrect.', 'userid');
        }

        if ($this->requiresOtp($user)) {
            $otp = $this->generateOtp();
            $user->update(['otp_reqpay' => Hash::make($otp)]);
            $request->session()->put('login_remember', $remember);

            $payload = [
                'status' => false,
                'requires_otp' => true,
                'message' => 'OTP verification required. Please enter the code to continue.',
            ];

            if (app()->environment(['local', 'testing'])) {
                $payload['otp'] = $otp;
            }

            return $this->jsonResponse($request, $payload);
        }

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return $this->jsonResponse($request, [
            'success' => true,
            'status' => true,
            'redirect' => route('user.dashboard'),
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'userid' => ['required', 'string'],
            'otp' => ['required', 'digits:6'],
        ], [
            'userid.required' => 'Please enter your user ID.',
            'otp.required' => 'Please enter the OTP sent to you.',
            'otp.digits' => 'The OTP must be 6 digits.',
        ]);

        $submittedUserid = trim($request->input('userid'));
        $submittedOtp = trim($request->input('otp'));

        $user = User::where('userid', $submittedUserid)
            ->where('regtype', 4)
            ->first();

        if (! $user) {
            return $this->jsonError($request, 'No account found for this user ID with regtype 4.', 'userid');
        }

        $status = (string) ($user->status ?? '0');
        if (! in_array($status, ['1', 'active'], true)) {
            return $this->jsonError($request, 'Your account is inactive. Please contact support.', 'userid');
        }

        if (empty($user->otp_reqpay) || ! Hash::check($submittedOtp, $user->otp_reqpay)) {
            return $this->jsonError($request, 'The OTP you entered is incorrect.', 'otp');
        }

        $user->update(['otp_reqpay' => null]);

        $remember = $request->session()->pull('login_remember', false);
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return $this->jsonResponse($request, [
            'success' => true,
            'status' => true,
            'redirect' => route('user.dashboard'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function requiresOtp(User $user): bool
    {
        return (string) ($user->isotpverify ?? '0') === '1';
    }

    private function generateOtp(): string
    {
        return (string) random_int(100000, 999999);
    }

    private function jsonResponse(Request $request, array $payload): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($payload);
        }

        if (! empty($payload['success'])) {
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors($payload['errors'] ?? [])->withInput();
    }

    private function jsonError(Request $request, string $message, string $field = 'userid'): JsonResponse|RedirectResponse
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
