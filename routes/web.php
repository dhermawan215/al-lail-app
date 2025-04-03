<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\Admin\SystemLogController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryTransactionController;
use App\Http\Controllers\Admin\FinancialPostManagement;
use App\Http\Controllers\Admin\MasjidManagementController;
use App\Http\Controllers\Members\MasjidController;
use App\Http\Controllers\Members\PosKeuanganController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsVerified;

Route::get('/', function () {
    return view('welcome');
});

//auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');
    Route::post('/login/process', [AuthenticatedController::class, 'processedLogin']);
    Route::get('/forgot-password', [AuthenticatedController::class, 'forgotPassword'])->name('forgot_password');
    Route::post('/forgot-password/process', [AuthenticatedController::class, 'processForgotPassword'])->name('forgot_password_process');
    Route::get('/forgot-password/success', [AuthenticatedController::class, 'forgotPasswordSuccess'])->name('forgot_password_success');
    Route::get('/forgot-password/check-email', [AuthenticatedController::class, 'checkEmail'])->name('forgot_password_check_email');
    Route::get('/change-password/{token}', [AuthenticatedController::class, 'checkToken'])->name('check_token');
    Route::put('/change-password/{token}/processing', [AuthenticatedController::class, 'processingChangePassword'])->name('processing_change_password');
    Route::get('/register-membership', [AuthenticatedController::class, 'registerMembership'])->name('register_membership');
    Route::post('/register-membership/process', [AuthenticatedController::class, 'processRegisterMembership'])->name('process_register_membership');
    Route::get('/register-membership/success', [AuthenticatedController::class, 'successRegister'])->name('register_success');
    Route::get('/Activation-account/{token}', [AuthenticatedController::class, 'activationAccount'])->name('activation_account');
});
//dashboard routes
Route::middleware(['auth', IsVerified::class])->group(function () {
    Route::post('/logout', [AuthenticatedController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/profile', [UserProfileController::class, 'profile'])->name('profile');
    Route::post('/user/profile/update-password', [UserProfileController::class, 'updatePassword']);
    Route::post('/user/profile/update-profile', [UserProfileController::class, 'updateProfile']);
    Route::post('/user/profile/update-email', [UserProfileController::class, 'updateEmail']);
    //management masjid for members
    Route::prefix('members')->group(function () {
        Route::controller(MasjidController::class)->group(function () {
            Route::get('/masjid-management', 'index')->name('members.masjid_management');
            Route::post('/masjid-management/list', 'listData');
            Route::post('/masjid-management/detail', 'detail');
            Route::post('/masjid-management/delete', 'destroy');
            Route::post('/masjid-management/save', 'store');
            Route::post('/masjid-management/edit', 'edit');
            Route::post('/masjid-management/update', 'update');
        });
        //pos keuangan controller
        Route::controller(PosKeuanganController::class)->group(function () {
            Route::get('/pos-keuangan', 'index')->name('members.pos_keuangan');
            Route::post('/pos-keuangan/list', 'listData');
            Route::post('/pos-keuangan/save', 'store');
            Route::post('/pos-keuangan/edit', 'edit');
            Route::post('/pos-keuangan/update', 'update');
            Route::post('/pos-keuangan/delete', 'destroy');
        });
    });
});


//Route for admin
Route::prefix('admin')->middleware(['auth', IsAdmin::class, IsVerified::class])->group(function () {
    //admin user management route
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/users-management', 'index')->name('admin.users_management');
        Route::post('/users-management/list', 'listData');
        Route::post('/users-management/user-active', 'changeUserActive');
    });
    //admin category controller
    Route::controller(CategoryTransactionController::class)->group(function () {
        Route::get('/category-transaction', 'index')->name('admin.category_transaction');
        Route::post('/category-transaction/list', 'listData');
        Route::post('/category-transaction/save', 'store');
        Route::post('/category-transaction/edit', 'edit');
        Route::post('/category-transaction/update', 'update');
        Route::post('/category-transaction/delete', 'destroy');
    });
    //admin system log controller
    Route::controller(SystemLogController::class)->group(function () {
        Route::get('/system-log', 'index')->name('admin.system_log');
        Route::post('/system-log/list', 'listData');
    });
    //admin masjid management
    Route::controller(MasjidManagementController::class)->group(function () {
        Route::get('/masjid-management', 'index')->name('admin.masjid_management');
        Route::post('/masjid-management/list', 'ListData');
        Route::post('/masjid-management/verifiying', 'verifiying');
        Route::post('/masjid-management/detail', 'detail');
    });
    //admin financial post management
    Route::controller(FinancialPostManagement::class)->group(function () {
        Route::get('/financial-post', 'index')->name('admin.financial_post');
        Route::post('/financial-post/list', 'ListData');
    });
});
