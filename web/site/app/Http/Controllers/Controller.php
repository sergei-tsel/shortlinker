<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getAuthenticatedUser(): ?User
    {
        $service = app(AuthService::class);

        return $service->getAuthenticatedUser();
    }

    public function getAuthenticatedUserId(): ?int
    {
        $service = app(AuthService::class);

        return $service->getAuthenticatedUserId();
    }
}
