<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Validators\User\LoginRequest;
use App\Http\Validators\User\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Контроллер авторизации пользователя
 */
class AuthController extends Controller
{
    /**
     * Регистрация пользователя
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $userRepository = new UserRepository();
        /** @var ?User $user */
        $user = $userRepository->findByNickname($credentials['nickname']);

        if (!$user) {
            $user = $userRepository->createByParams($credentials);
        }

        if (!Auth::attempt($credentials)) {
            response()->redirectToRoute('login');
        }

        $cookie = (new AuthService())->makeNewCookie($user);

        return response()->redirectToRoute('welcome')->withCookie($cookie);
    }

    /**
     * Вход пользователя
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $userRepository = new UserRepository();
        /** @var ?User $user */
        $user = $userRepository->findByNickname($credentials['nickname']);

        if (!$user || !Auth::attempt($credentials)) {
            response()->redirectToRoute('login');
        }

        $cookie = (new AuthService())->makeNewCookie($user);

        return response()->redirectToRoute('welcome')->withCookie($cookie);
    }

    /**
     * Выход пользователя
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $cookie = (new AuthService())->makeLogoutCookie();

        return response()->redirectToRoute('login')->withCookie($cookie);
    }
}
