<?php
declare(strict_types=1);

use App\Http\Controllers\LinkController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
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
    ->middleware('auth:web')
    ->name('welcome');

Route::group([
    'prefix' => 'user',
    'as'     => 'user.',
    'middleware' => 'auth:web',
], function () {
    Route::get('{id}/update', [UserController::class, 'update'])
        ->middleware('auth:web')
        ->name('update');

    Route::get('{id}/changePassword', [UserController::class, 'changePassword'])
        ->middleware('auth:web')
        ->name('changePassword');
});

Route::group([
    'prefix' => 'link',
    'as'     => 'link.',
    'middleware' => 'auth:web',
], function () {
    Route::get('create', function () {
        return view('link.create');
    })->middleware('auth:web')
        ->name('create');

    Route::get('{id}/resources', [LinkController::class, 'resources'])
        ->middleware('auth:web')
        ->name('resources');

    Route::get('{id}/update', [LinkController::class, 'update'])
        ->middleware('auth:web')
        ->name('update');
});
