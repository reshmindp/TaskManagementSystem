<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TaskController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'log.execution', 'api.auth'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::put('tasks/{task}/assign', [TaskController::class, 'assign']);
    Route::put('tasks/{task}/complete', [TaskController::class, 'complete']);
});