<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Guest Routes - Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
        Route::post('/login/verify-otp', [AdminLoginController::class, 'verifyOtp'])->name('login.verify_otp');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});

// User Authentication Routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login']);
    Route::post('/login/verify-otp', [UserLoginController::class, 'verifyOtp'])->name('login.verify_otp');

    // Registration routes
    Route::get('/register', [UserLoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [UserLoginController::class, 'register']);
});

// Protected Routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/send-sms', [DashboardController::class, 'sendSms'])->name('user.dashboard.send_sms');
    Route::get('/dashboard/campaigns', [DashboardController::class, 'campaigns'])->name('user.dashboard.campaigns');
    Route::get('/dashboard/contacts', [DashboardController::class, 'contacts'])->name('user.dashboard.contacts');
    Route::get('/dashboard/sender-ids', [DashboardController::class, 'senderIds'])->name('user.dashboard.sender_ids');
    Route::get('/dashboard/reports/delivery-summary', [DashboardController::class, 'deliverySummary'])->name('user.dashboard.reports.delivery_summary');
    Route::get('/dashboard/reports/billing-history', [DashboardController::class, 'billingHistory'])->name('user.dashboard.reports.billing_history');
    Route::get('/dashboard/reports/api-usage', [DashboardController::class, 'apiUsage'])->name('user.dashboard.reports.api_usage');
    Route::get('/dashboard/settings/profile', [DashboardController::class, 'profile'])->name('user.dashboard.settings.profile');
    Route::get('/dashboard/settings/api-keys', [DashboardController::class, 'apiKeys'])->name('user.dashboard.settings.api_keys');
    Route::get('/dashboard/settings/security', [DashboardController::class, 'security'])->name('user.dashboard.settings.security');
    Route::get('/dashboard/help-center', [DashboardController::class, 'helpCenter'])->name('user.dashboard.help_center');
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Add other admin routes here
});