<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Enums\LinkResourceType;
use App\Models\User;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *  Контроллер страниц для ссылки
 */
class LinkController extends Controller
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    )
    {
    }

    /**
     * Роут страницы связанных ссылок
     */
    public function resources(Request $request, int $id): View
    {
        $link = $this->linkRepository->getOneWithResources($id);

        return view('link.resources', compact('link'));
    }

    /**
     * Роут страницы изменения
     */
    public function update(Request $request, int $id): View
    {
        /** @var User $user */
        $user = $this->getAuthenticatedUser();

        $fromId = (int) $request->get('fromId') ?? null;

        $link = $this->linkRepository->findById($id);

        if ($link->resourceType === LinkResourceType::TO_URL || $link->resourceType === LinkResourceType::TO_FOLDER) {
            $folders = $this->linkRepository->getAvailableToAddByUser($user, LinkResourceType::TO_FOLDER, $link, $fromId);
        } else {
            $folders = null;
        }

        if ($link->resourceType === LinkResourceType::TO_URL) {
            $groups = $this->linkRepository->getAvailableToAddByUser($user, LinkResourceType::TO_GROUP, $link, $fromId);
        } else {
            $groups = null;
        }

        return view('link.update', compact('fromId', 'link', 'folders', 'groups'));
    }
}
