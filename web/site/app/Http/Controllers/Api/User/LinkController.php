<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Repositories\LinkRepository;
use App\Http\Validators\Link\AddResourceRequest;
use App\Http\Validators\Link\CreateRequest;
use App\Http\Validators\Link\UpdateRequest;
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

        $params['userId'] = $this->getAuthenticatedUserId();

        $this->linkRepository->createByParams($params);

        return response()->redirectToRoute('welcome');
    }

    /**
     * Изменить
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        $params = $request->validated();

        $params['userId'] = $this->getAuthenticatedUserId();

        $link = $this->linkRepository->findById($id);
        $this->linkRepository->updateByParams($link, $params);

        return response()->redirectToRoute('welcome');
    }

    /**
     * Удалить
     */
    public function delete(int $id): Response
    {
        $link = $this->linkRepository->findById($id);
        $this->linkRepository->delete($link);

        return response()->redirectToRoute('welcome');
    }

    /**
     * Добавить ресурс
     */
    public function addResource(AddResourceRequest $request, int $id): Response
    {
        $toLink   = $this->linkRepository->findById((int) $request->get('toId'));
        $this->linkRepository->addResource($toLink, $id);

        return response()->redirectToRoute('welcome');
    }

    /**
     * Переместить ресурс
     */
    public function moveResource(AddResourceRequest $request, int $id, int $fromId): Response
    {
        $toLink   = $this->linkRepository->findById((int) $request->get('toId'));
        $fromLink = $this->linkRepository->findById($fromId);
        $this->linkRepository->addResource($toLink, $id);
        $this->linkRepository->removeResource($fromLink, $id);

        return response()->redirectToRoute('welcome');
    }

    /**
     * Удалить ресурс
     */
    public function removeResource(int $id, int $fromId): Response
    {
        $fromLink = $this->linkRepository->findById($fromId);
        $this->linkRepository->removeResource($fromLink, $id);

        return response()->redirectToRoute('welcome');
    }
}
