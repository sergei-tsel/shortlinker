<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validators\Admin\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Конроллер авторизации в админке
 */
class AuthController extends Controller
{
    /**
     * Вход в админку
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
        };

        return response()->redirectToRoute('admin.welcome');
    }

    /**
     * Выход из админки
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        return response()->redirectToRoute('admin.login');
    }
}
