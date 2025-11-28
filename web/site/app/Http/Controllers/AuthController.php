<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Validators\User\LoginRequest;
use App\Http\Validators\User\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Конроллер авторизации пользователя
 */
class AuthController extends Controller
{
    /**
     * Регистрация пользователя
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $credentials = [
            'name'     => $params['name'],
            'nickname' => $params['nickname'],
            'password' => $params['password'],
        ];

        (new UserRepository())->createByParams($credentials);

        if (Auth::attempt($credentials, isset($params['remember'])))
        {
            $request->session()->regenerate();
        };

        return response()->redirectToRoute('welcome');
    }

    /**
     * Вход пользователя
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $credentials = [
            'nickname' => $params['nickname'],
            'password' => $params['password'],
        ];

        if (Auth::attempt($credentials, isset($params['remember'])))
        {
            $request->session()->regenerate();
        };

        return response()->redirectToRoute('welcome');
    }

    /**
     * Выход пользователя
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        return response()->redirectToRoute('login');
    }
}
