<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Task\V1\CreateTaskController;
use App\Http\Controllers\Task\V1\DeleteTaskController;
use App\Http\Controllers\Task\V1\ListTasksController;
use App\Http\Controllers\Task\V1\ToggleTaskStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->group(function () {
        Route::get('tasks', ListTasksController::class)->name('task.list');
        Route::post('tasks', CreateTaskController::class)->name('task.create');
        Route::patch('tasks/{task}', ToggleTaskStatusController::class)->name('task.update');
        Route::delete('tasks/{task}', DeleteTaskController::class)->name('task.delete');
    }
    );

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')->name('logout');
