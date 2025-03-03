<?php

use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticatedController;

Route::get('/', function () {
    return view('welcome');
});

//auth routes
Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');

//dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


//Route for admin
Route::prefix('admin')->group(function () {
    //admin user management route
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/users-management', 'index')->name('users_management');
        Route::post('/users-management/list', 'listData');
    });
});
