<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
// Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']);

Route::post('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted']);

Route::post('/tasks/{id}/toggle', [TaskController::class, 'toggleTaskCompletion']);

