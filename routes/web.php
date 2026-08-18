<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\HelpController;
use App\Http\Controllers\admin\ManageController;
use App\Http\Controllers\admin\MasterController;
use App\Http\Controllers\admin\PackageController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SchedulerController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\user\DashboardController as UserDashboardController;
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

// Protected Routes - User
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/dashboard/send-sms', [UserDashboardController::class, 'sendSms'])->name('user.dashboard.send_sms');
    Route::get('/dashboard/campaigns', [UserDashboardController::class, 'campaigns'])->name('user.dashboard.campaigns');
    Route::get('/dashboard/contacts', [UserDashboardController::class, 'contacts'])->name('user.dashboard.contacts');
    Route::get('/dashboard/sender-ids', [UserDashboardController::class, 'senderIds'])->name('user.dashboard.sender_ids');
    Route::get('/dashboard/reports/delivery-summary', [UserDashboardController::class, 'deliverySummary'])->name('user.dashboard.reports.delivery_summary');
    Route::get('/dashboard/reports/billing-history', [UserDashboardController::class, 'billingHistory'])->name('user.dashboard.reports.billing_history');
    Route::get('/dashboard/reports/api-usage', [UserDashboardController::class, 'apiUsage'])->name('user.dashboard.reports.api_usage');
    Route::get('/dashboard/settings/profile', [UserDashboardController::class, 'profile'])->name('user.dashboard.settings.profile');
    Route::get('/dashboard/settings/api-keys', [UserDashboardController::class, 'apiKeys'])->name('user.dashboard.settings.api_keys');
    Route::get('/dashboard/settings/security', [UserDashboardController::class, 'security'])->name('user.dashboard.settings.security');
    Route::get('/dashboard/help-center', [UserDashboardController::class, 'helpCenter'])->name('user.dashboard.help_center');
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');
});

// Protected Routes - Admin
Route::middleware(['auth:admin', 'admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Master Menu
    Route::get('/admin/master/company-setup', [MasterController::class, 'companySetup'])->name('admin.master.company_setup');
    Route::get('/admin/master/admin-register', [MasterController::class, 'adminRegister'])->name('admin.master.admin_register');
    Route::post('/admin/master/admin-register/action', [MasterController::class, 'handleAdminAction'])->name('admin.master.admin_register.action');
    Route::get('/admin/master/user-register', [MasterController::class, 'userRegister'])->name('admin.master.user_register');
    Route::post('/admin/master/user-register/action', [MasterController::class, 'handleUserAction'])->name('admin.master.user_register.action');

    // Account Menu
    Route::get('/admin/account/add-bank', [AccountController::class, 'addBank'])->name('admin.account.add_bank');
    Route::post('/admin/account/add-bank/action', [AccountController::class, 'handleBankAction'])->name('admin.account.add_bank.action');
    Route::get('/admin/account/fund-transfer', [AccountController::class, 'fundTransfer'])->name('admin.account.fund_transfer');
    Route::get('/admin/account/fund-transfer/data', [AccountController::class, 'getFundTransferData'])->name('admin.account.fund_transfer.data');
    Route::post('/admin/account/fund-transfer/action', [AccountController::class, 'handleFundTransferAction'])->name('admin.account.fund_transfer.action');

    // Package Menu
    Route::get('/admin/package/new-package', [PackageController::class, 'newPackage'])->name('admin.package.new_package');
    Route::post('/admin/package/new-package/action', [PackageController::class, 'handlePackageAction'])->name('admin.package.new_package.action');

    // Scheduler Menu
    Route::get('/admin/scheduler/sms-api', [SchedulerController::class, 'smsApi'])->name('admin.scheduler.sms_api');
    Route::post('/admin/scheduler/sms-api/action', [SchedulerController::class, 'handleSmsApiAction'])->name('admin.scheduler.sms_api.action');
    Route::post('/admin/scheduler/sms-api/toggle-status', [SchedulerController::class, 'toggleStatus'])->name('admin.scheduler.sms_api.toggle_status');

    // Manage Item Menu
    Route::get('/admin/manage/sender-id', [ManageController::class, 'senderId'])->name('admin.manage.sender_id');
    Route::get('/admin/manage/template', [ManageController::class, 'template'])->name('admin.manage.template');

    // Report Menu
    Route::get('/admin/reports/sms-details', [ReportController::class, 'smsDetails'])->name('admin.reports.sms_details');
    Route::get('/admin/reports/sms-live-panel', [ReportController::class, 'smsLivePanel'])->name('admin.reports.sms_live_panel');
    Route::get('/admin/reports/user-details', [ReportController::class, 'userDetails'])->name('admin.reports.user_details');
    Route::get('/admin/reports/fund-transfer', [ReportController::class, 'fundTransferReport'])->name('admin.reports.fund_transfer');
    Route::get('/admin/reports/all-user-ledger', [ReportController::class, 'allUserLedger'])->name('admin.reports.all_user_ledger');
    Route::get('/admin/reports/user-wise-ledger', [ReportController::class, 'userWiseLedger'])->name('admin.reports.user_wise_ledger');

    // Help Menu
    Route::get('/admin/help/help-setup', [HelpController::class, 'helpSetup'])->name('admin.help.help_setup');
    Route::get('/admin/help/notification', [HelpController::class, 'notification'])->name('admin.help.notification');

    // Settings Menu
    Route::get('/admin/settings/profile', [SettingsController::class, 'profile'])->name('admin.dashboard.settings.profile');
    Route::get('/admin/settings/api-keys', [SettingsController::class, 'apiKeys'])->name('admin.dashboard.settings.api_keys');
    Route::get('/admin/settings/security', [SettingsController::class, 'security'])->name('admin.dashboard.settings.security');

    // Logout
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});