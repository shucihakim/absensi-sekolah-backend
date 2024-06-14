<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard_web'])->name('adashboard');
Route::get('/verify', [AuthController::class, 'verify'])->name('auth.verify');