<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web([
            \App\Http\Middlewares\VerifyCsrfToken::class,
            \App\Http\Middlewares\EncryptCookies::class,
        ], [], [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
        ]);

        $middleware->use([
            \App\Http\Middlewares\TrustProxies::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (Throwable $exception) {
            return back();
        });
    })->create();
