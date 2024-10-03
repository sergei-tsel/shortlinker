<?php
declare(strict_types=1);

use App\Http\App\User\Controllers\AuthController;
use App\Http\App\User\Controllers\LinkController;
use App\Http\App\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register'])
    ->name('register');

Route::post('login', [AuthController::class, 'login'])
    ->name('login');

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:web')
    ->name('logout');

Route::group([
    'prefix' => 'user',
    'as'     => 'user.',
    'middleware' => 'auth:web',
], function () {
    Route::post('{id}/update', [UserController::class, 'update'])
        ->middleware('auth:web')
        ->name('update');

    Route::post('{id}/changePassword', [UserController::class, 'changePassword'])
        ->middleware('auth:web')
        ->name('changePassword');
});

Route::group([
    'prefix' => 'link',
    'as'     => 'link.',
    'middleware' => 'auth:web',
], function () {
    Route::post('create', [LinkController::class, 'create'])
        ->name('create');

    Route::post('{id}/update', [LinkController::class, 'update'])
        ->name('update');

    Route::post('{id}/delete', [LinkController::class, 'delete'])
        ->name('delete');

    Route::post('{id}/add', [LinkController::class, 'addResource'])
        ->name('addResource');

    Route::post('{id}/moveFrom/{fromId}', [LinkController::class, 'moveResource'])
        ->name('moveResource');

    Route::post('{id}/removeFrom/{fromId}', [LinkController::class, 'removeResource'])
        ->name('removeResource');
});
