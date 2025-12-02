<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер методов сущности "Авторизированный пользователь"
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * Заблокировать
     */
    public function block(int $id): Response
    {
        $user = $this->userRepository->findById($id);
        $this->userRepository->delete($user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Разблокировать
     */
    public function unblock(int $id): Response
    {
        $user = $this->userRepository->findById($id, true);
        $this->userRepository->restore($user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
