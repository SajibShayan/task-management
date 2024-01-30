<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';

Route::group([], function () {
    Route::prefix('task')->as('tasks:')
    ->group(
        base_path('routes/resources/task.php'),
    );
});
