<?php

use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

// Route::middleware('guest')->group(function () {
    Route::get('/hi',  function () {
        return response()->json(['message' => 'ok'], 200);
    });
    Route::post('/register', RegisterUserController::class)->name('register');
    Route::post('/login', function () {
        return response()->json(['message' => 'ok'], 200);
    });
// });

Route::middleware('auth:sanctum')->group(function () {

});

