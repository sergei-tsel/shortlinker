<?php
declare(strict_types=1);

use App\Http\Controllers\LinkController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middlewares\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('register', function () {
    return view('register');
})->name('register');

Route::get('welcome', [PageController::class, 'welcome'])
    ->middleware(Authenticate::class . ':web')
    ->name('welcome');

Route::group([
    'prefix' => 'auth',
    'as'     => 'auth.',
], function () {
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware(Authenticate::class . ':web')
        ->name('logout');
});

Route::group([
    'prefix' => 'user',
    'as'     => 'user.',
    'middleware' => 'auth:web',
], function () {
    Route::get('{id}/update', [UserController::class, 'update'])
        ->middleware(Authenticate::class . ':web')
        ->name('update');

    Route::get('{id}/changePassword', [UserController::class, 'changePassword'])
        ->middleware(Authenticate::class . ':web')
        ->name('changePassword');
});

Route::group([
    'prefix' => 'link',
    'as'     => 'link.',
    'middleware' => Authenticate::class . ':web',
], function () {
    Route::get('create', function () {
        return view('link.create');
    })->middleware(Authenticate::class . ':web')
        ->name('create');

    Route::get('{id}/resources', [LinkController::class, 'resources'])
        ->middleware(Authenticate::class . ':web')
        ->name('resources');

    Route::get('{id}/update', [LinkController::class, 'update'])
        ->middleware(Authenticate::class . ':web')
        ->name('update');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    Route::get('/', function () {
        return view('admin.login');
    })->name('login');

    Route::get('welcome', function () {
        return view('admin.welcome');
    })->middleware(Authenticate::class . ':admin')
        ->name('welcome');

    Route::group([
        'prefix' => 'auth',
        'as'     => 'auth.',
    ], function () {
        Route::post('login', [AdminAuthController::class, 'login'])
            ->name('login');

        Route::post('logout', [AdminAuthController::class, 'logout'])
            ->middleware(Authenticate::class . ':admin')
            ->name('logout');
    });

    Route::group([
        'prefix' => 'user',
        'as'     => 'user.',
        'middleware' => Authenticate::class . ':admin',
    ], function () {
        Route::get('all', [AdminUserController::class, 'getAll'])
            ->name('all');

        Route::post('search', [AdminUserController::class, 'search'])
            ->name('search');
    });

    Route::group([
        'prefix' => 'link',
        'as'     => 'link.',
        'middleware' => Authenticate::class . ':admin',
    ], function () {
        Route::get('all', [AdminLinkController::class, 'getAll'])
            ->name('all');

        Route::post('search', [AdminLinkController::class, 'search'])
            ->name('search');
    });
});
