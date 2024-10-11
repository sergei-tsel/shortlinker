<?php
declare(strict_types=1);
namespace App\Http\App\User\Controllers;

use App\Http\App\User\Requests\User\ChangePasswordRequest;
use App\Http\App\User\Requests\User\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер для пользователя
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * Изменить
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        $params = $request->validated();

        $user = $this->userRepository->getOneById($id);
        $this->userRepository->updateByParams($user, $params);

        return response()->redirectToRoute('welcome');
    }

    /**
     * Изменить пароль
     */
    public function changePassword(ChangePasswordRequest $request, int $id): Response
    {
        $user = $this->userRepository->getOneById($id);
        $this->userRepository->changePassword($user, $request->get('newpassword'));

        return response()->redirectToRoute('welcome');
    }
}
