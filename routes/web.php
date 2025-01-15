<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RequestTime;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(\App\Http\Middleware\RequestTime::class)->group(function () {
    Route::get('/times', function () {
        return response()->json(['message' => 'Times route works!']);
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/files', [FileController::class, 'list'])->name('files.list');
    Route::get('/files/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/{id}', [FileController::class, 'show'])->name('files.show');
    Route::get('/files/{id}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/files/{id}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__.'/auth.php';
