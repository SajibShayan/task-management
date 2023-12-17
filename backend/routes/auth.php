<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('/register', RegisterUserController::class)->name('register');
});

Route::middleware('auth:sanctum')->group(function () {

});

