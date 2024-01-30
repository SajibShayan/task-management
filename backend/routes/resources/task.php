<?php
declare(strict_types=1);

use App\Http\Controllers\Admin\Task\CreateTaskController;
use App\Http\Controllers\Admin\Task\DestroyTaskController;
use App\Http\Controllers\Admin\Task\IndexTaskController;
use App\Http\Controllers\Admin\Task\UpdateTaskController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth:sanctum'])->group(function () {

    // task route
    Route::get('/', IndexTaskController::class);
    Route::post('/', CreateTaskController::class);
    Route::put('/{task}', UpdateTaskController::class);
    Route::delete('/{task}', DestroyTaskController::class);


});