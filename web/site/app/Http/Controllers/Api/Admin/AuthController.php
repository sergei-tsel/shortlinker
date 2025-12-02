<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Validators\Admin\LoginRequest;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Контроллер авторизации в админке
 */
class AuthController extends Controller
{
    /**
     * Вход в админку
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $adminRepository = new AdminRepository();
        /** @var ?Admin $admin */
        $admin = $adminRepository->findByLogin($credentials['login']);

        if (!$admin || !Auth::guard('admin')->attempt($credentials)) {
            response()->redirectToRoute('admin.login');
        }

        $cookie = (new AuthService())->makeNewCookie($admin);

        return response()->redirectToRoute('admin.welcome')->withCookie($cookie);
    }

    /**
     * Выход из админки
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $cookie = (new AuthService())->makeLogoutCookie();

        return response()->redirectToRoute('admin.login')->withCookie($cookie);
    }
}
