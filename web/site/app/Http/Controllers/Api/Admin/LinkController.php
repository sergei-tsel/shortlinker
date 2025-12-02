<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api\Admin;

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
        $link = $this->linkRepository->findById($id);
        $this->linkRepository->delete($link);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Восстановить
     */
    public function restore(int $id): Response
    {
        $link = $this->linkRepository->findById($id, true);
        $this->linkRepository->restore($link);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
