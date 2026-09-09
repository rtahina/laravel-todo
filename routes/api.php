<?php

declare(strict_types=1);

use App\Http\Controllers\Task\V1\CreateTaskController;
use App\Http\Controllers\Task\V1\DeleteTaskController;
use App\Http\Controllers\Task\V1\ListTasksController;
use App\Http\Controllers\Task\V1\ToggleTaskStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::get('tasks', ListTasksController::class);
    Route::post('tasks', CreateTaskController::class);
    Route::patch('tasks/{id}', ToggleTaskStatusController::class);
    Route::delete('tasks/{id}', DeleteTaskController::class);
});
