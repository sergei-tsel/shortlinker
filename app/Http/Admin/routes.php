<?php
declare(strict_types=1);

use App\Http\Admin\Controllers\LinkController;
use App\Http\Admin\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.login');
})->name('login');

Route::get('welcome', function () {
    return view('admin.welcome');
})->middleware('auth:admin')
    ->name('welcome');

Route::group([
    'prefix' => 'user',
    'as'     => 'user.',
    'middleware' => 'auth:admin',
], function () {
    Route::get('all', [UserController::class, 'getAll'])
        ->name('all');

    Route::post('search', [UserController::class, 'search'])
        ->name('search');
});

Route::group([
    'prefix' => 'link',
    'as'     => 'link.',
    'middleware' => 'auth:admin',
], function () {
    Route::get('all', [LinkController::class, 'getAll'])
        ->name('all');

    Route::post('search', [LinkController::class, 'search'])
        ->name('search');
});

