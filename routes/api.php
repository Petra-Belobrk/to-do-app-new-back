<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('/register', RegisterController::class)->name('auth.register');
    Route::post('/login', LoginController::class)->name('auth.login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', LogoutController::class)->name('auth.logout');
    Route::prefix('tasks')->group(function() {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.list');
        Route::post('/', [TaskController::class, 'store'])->name('tasks.create');
        Route::get('/deleted', [TaskController::class, 'trashed'])->name('tasks.trashed');
        Route::get('/restore/{id}', [TaskController::class, 'restore'])->name('tasks.restore');
        Route::put('/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::get('/{id}', [TaskController::class, 'show'])->name('tasks.show');
        Route::delete('/{id}', [TaskController::class, 'delete'])->name('tasks.delete');
    });
});
