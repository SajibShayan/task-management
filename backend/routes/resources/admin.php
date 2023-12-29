<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])->group(function () {

    // dashboard route
    Route::group(['as' => 'dashboard:'], function () {
        // Route::get('/', IndexDashboardController::class)->name('index');
    });

});