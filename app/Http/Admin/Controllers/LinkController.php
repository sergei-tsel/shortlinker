<?php
declare(strict_types=1);
namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\PaginateRequest;
use App\Http\Controllers\Controller;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Контроллер страниц сущности "Добавленная ссылка"
 */
class LinkController extends Controller
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
    )
    {
    }

    /**
     * Роут страницы со всеми
     */
    public function getAll(PaginateRequest $request): View
    {
        $models = $this->linkRepository->getAll((int) $request->get('page') ?? 1);

        return view('admin.links', compact('models'));
    }

    /**
     * Роут страницы с результатами поиска
     */
    public function search(Request $request): View
    {
        $models = $this->linkRepository->searchByQuery($request->get('query') ?? '');

        return view('admin.links', compact('models'));
    }
}
