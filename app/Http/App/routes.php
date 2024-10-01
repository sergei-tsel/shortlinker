<?php
declare(strict_types=1);

use App\Http\App\Controllers\AuthController;
use App\Http\App\Controllers\LinkController;
use App\Http\App\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])
    ->name('login');

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:admin')
    ->name('logout');

Route::group([
    'prefix' => 'user',
    'as'     => 'user.',
    'middleware' => 'auth:admin',
], function () {
    Route::post('{id}/block', [UserController::class, 'block'])
        ->name('block');

    Route::post('{id}/unblock', [UserController::class, 'unblock'])
        ->name('unblock');
});

Route::group([
    'prefix' => 'link',
    'as'     => 'link.',
    'middleware' => 'auth:admin',
], function () {
    Route::post('{id}/delete', [LinkController::class, 'delete'])
        ->name('delete');

    Route::post('{id}/unblock', [LinkController::class, 'restore'])
        ->name('restore');
});
