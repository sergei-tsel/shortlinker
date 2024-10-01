<?php
declare(strict_types=1);
namespace App\Http\App\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\LinkRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер методов сущности "Добавленная ссылка"
 */
class LinkController extends Controller
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    )
    {
    }

    /**
     * Удалить
     */
    public function delete(int $id): Response
    {
        $user = $this->linkRepository->getOneById($id);
        $this->linkRepository->delete($user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Восстановить
     */
    public function restore(int $id): Response
    {
        $user = $this->linkRepository->getOneById($id, true);
        $this->linkRepository->restore($user);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
