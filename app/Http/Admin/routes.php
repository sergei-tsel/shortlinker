<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.login');
})->name('login');

Route::get('welcome', function () {
    return view('admin.welcome');
})->middleware('auth:admin')
    ->name('welcome');
