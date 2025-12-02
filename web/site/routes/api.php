<?php
declare(strict_types=1);

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\LinkController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\ExternalController;
use App\Http\Middlewares\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/away/{shortUrl}', [ExternalController::class, 'getAway'])
    ->name('api.away');

Route::get('/aways/{shortUrl}', [ExternalController::class, 'getManyUrlsToAway'])
    ->name('api.aways');

Route::group([
    'prefix' => 'admin',
    'as'     => 'api.admin.',
], function () {
    Route::post('login', [AdminAuthController::class, 'login'])
        ->name('login');

    Route::post('logout', [AdminAuthController::class, 'logout'])
        ->middleware(Authenticate::class . ':admin')
        ->name('logout');

    Route::group([
        'prefix' => 'user',
        'as'     => 'user.',
        'middleware' => Authenticate::class . ':admin',
    ], function () {
        Route::post('{id}/block', [AdminUserController::class, 'block'])
            ->name('block');

        Route::post('{id}/unblock', [AdminUserController::class, 'unblock'])
            ->name('unblock');
    });

    Route::group([
        'prefix'     => 'link',
        'as'         => 'link.',
        'middleware' => Authenticate::class . ':admin',
    ], function () {
        Route::post('{id}/delete', [AdminLinkController::class, 'delete'])
            ->name('delete');

        Route::post('{id}/unblock', [AdminLinkController::class, 'restore'])
            ->name('restore');
    });
});

Route::group([
    'prefix' => 'user',
    'as'     => 'api.user.',
], function () {
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware(Authenticate::class)
        ->name('logout');

    Route::post('{id}/update', [UserController::class, 'update'])
        ->middleware(Authenticate::class)
        ->name('update');

    Route::post('{id}/changePassword', [UserController::class, 'changePassword'])
        ->middleware(Authenticate::class)
        ->name('changePassword');

    Route::group([
        'prefix' => 'link',
        'as'     => 'link.',
        'middleware' => Authenticate::class,
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
});
