<?php
declare(strict_types=1);

use App\Http\App\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])
    ->name('login');

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:admin')
    ->name('logout');
