<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\RequestTime;
use App\Http\Middleware\RolePermissionMiddleware;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TaskController;

Route::get('/', [DashboardController::class, 'index'])
	->middleware(['auth', 'verified'])
	->name('dashboard');

Route::middleware(RequestTime::class)->group(function () {
    Route::get('/times', function () {
        return response()->json(['message' => 'Times route works!']);
    });
});

Route::prefix('accounts')->middleware(['auth'])->group(function () {
    Route::get('/', [AccountController::class, 'list'])->name('accounts.list');
    Route::get('/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/store', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
});

Route::prefix('roles')->middleware(['auth'])->group(function () {
    Route::get('/', [RoleController::class, 'list'])->name('roles.list');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::prefix('permissions')->middleware(['auth'])->group(function () {
    Route::get('/', [PermissionController::class, 'list'])->name('permissions.list');
    Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
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
    Route::put('/files/{id}', [FileController::class, 'update'  ])->name('files.update');
    Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::get('/tasks', [TaskController::class, 'list'])->name('tasks.list');
	Route::post('/tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
	Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::get('/403', function () {
    return view('errors.403');
})->name('error.403');


require __DIR__.'/auth.php';
