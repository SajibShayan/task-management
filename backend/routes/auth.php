<?php

use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
   Route::post('/register', RegisterUserController::class)->name('register');
});

Route::middleware('auth:sanctum')->group(function () {
    
});