<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\Admin\SystemLogController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryTransactionController;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});

//auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');
    Route::post('/login/process', [AuthenticatedController::class, 'processedLogin']);
});
//dashboard routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/profile', [UserProfileController::class, 'profile'])->name('profile');
    Route::post('/user/profile/update-password', [UserProfileController::class, 'updatePassword']);
    Route::post('/user/profile/update-profile', [UserProfileController::class, 'updateProfile']);
    Route::post('/user/profile/update-email', [UserProfileController::class, 'updateEmail']);
});


//Route for admin
Route::prefix('admin')->middleware(['auth'])->group(function () {
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
});
