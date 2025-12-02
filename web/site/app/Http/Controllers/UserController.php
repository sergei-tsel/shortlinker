<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\View\View;

/**
 *  Контроллер страниц для пользователя
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * Роут страницы изменения имени
     */
    public function update(int $id): View
    {
        $user = $this->userRepository->findById($id);

        return view('user.update', compact('user'));
    }

    /**
     * Роут страницы изменения пароля
     */
    public function changePassword(int $id): View
    {
        $user = $this->userRepository->findById($id);

        return view('user.password', compact('user'));
    }
}
