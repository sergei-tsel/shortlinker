<?php
declare(strict_types=1);

use App\Http\Controllers\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Middlewares\Authenticate;
use App\Http\Middlewares\RedirectIfAuthenticated;
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
})->middleware(RedirectIfAuthenticated::class, 'web')
    ->name('login');

Route::get('register', function () {
    return view('register');
})->name('register');

Route::get('welcome', [PageController::class, 'welcome'])
    ->middleware(Authenticate::class)
    ->name('welcome');

Route::group([
    'prefix'     => 'user',
    'as'         => 'user.',
    'middleware' => Authenticate::class,
], function () {
    Route::get('{id}/update', [UserController::class, 'update'])
        ->name('update');

    Route::get('{id}/changePassword', [UserController::class, 'changePassword'])
        ->name('changePassword');
});

Route::group([
    'prefix'     => 'link',
    'as'         => 'link.',
    'middleware' => Authenticate::class,
], function () {
    Route::get('create', function () {
        return view('link.create');
    })->name('create');

    Route::get('{id}/resources', [LinkController::class, 'resources'])
        ->name('resources');

    Route::get('{id}/update', [LinkController::class, 'update'])
        ->name('update');
});

Route::group([
    'prefix' => 'admin',
    'as'     => 'admin.',
], function () {
    Route::get('/', function () {
        return view('admin.login');
    })->name('login');

    Route::get('welcome', function () {
        return view('admin.welcome');
    })->middleware(Authenticate::class . ':admin')
        ->name('welcome');

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
