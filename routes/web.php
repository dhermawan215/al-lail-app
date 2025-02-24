<?php

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
