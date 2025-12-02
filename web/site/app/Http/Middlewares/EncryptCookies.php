<?php
declare(strict_types=1);
namespace App\Http\Middlewares;

use App\Services\AuthService;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        AuthService::COOKIE_NAME,
    ];
}
