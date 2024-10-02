<?php
declare(strict_types=1);
namespace App\Http\App\User\Controllers;

use App\Http\App\User\Requests\Link\CreateRequest;
use App\Http\App\User\Requests\Link\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Repositories\LinkRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер для ссылки
 */
class LinkController extends Controller
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    )
    {
    }

    /**
     * Создать
     */
    public function create(CreateRequest $request): Response
    {
        $params = $request->validated();

        $params['userId'] = Auth::id();

        $this->linkRepository->createByParams($params);

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Изменить
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        $params = $request->validated();

        $params['userId'] = Auth::id();

        $link = $this->linkRepository->getOneById($id);
        $this->linkRepository->updateByParams($link, $params);

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Удалить
     */
    public function delete(int $id): Response
    {
        $link = $this->linkRepository->getOneById($id);
        $this->linkRepository->delete($link);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Добавить в папку
     */
    public function addToFolder(int $id, int $folderId): Response
    {
        $folder = $this->linkRepository->getOneById($folderId);
        $link   = $this->linkRepository->getOneById($id);
        $this->linkRepository->addToFolder($folder, $link);

        return response()->json([], Response::HTTP_OK);
    }

    /**
     * Добавить группу
     */
    public function addGroup(int $id, int $groupId): Response
    {
        $link  = $this->linkRepository->getOneById($id);
        $group = $this->linkRepository->getOneById($groupId);
        $this->linkRepository->addGroup($link, $group);

        return response()->json([], Response::HTTP_OK);
    }
}
