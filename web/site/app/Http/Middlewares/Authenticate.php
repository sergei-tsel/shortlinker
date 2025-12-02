<?php
declare(strict_types=1);
namespace App\Http\Middlewares;

use App\Repositories\UserRepository;
use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        $service = app(AuthService::class);

        $userId = $service->getUserIdFromRequest($request);

        if ($userId === null) {
            return $this->fail(str_contains($request->url(), 'admin'));
        }

        $repo = app(UserRepository::class);
        $user = $repo->findById($userId, true);

        if ($user === null || $user->trashed()) {
            return $this->fail(str_contains($request->url(), 'admin'));
        }

        return $next($request);
    }

    private function fail(bool $isAdmin): Response
    {
        $service = app(AuthService::class);
        $isJson  = \Illuminate\Support\Facades\Request::isJson();

        $response = !$isJson
            ? $isAdmin ? redirect("/admin") : redirect("/")
            : response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);

        return $response->withCookie($service->makeLogoutCookie());
    }
}
