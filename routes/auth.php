<?php

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Support\Facades\Route;

// --------------------------------------------------------------------------
// Login & Logout
// --------------------------------------------------------------------------
Route::get('/login', [AuthController::class, 'index'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
