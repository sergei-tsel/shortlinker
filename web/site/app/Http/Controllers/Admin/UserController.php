<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Validators\PaginateRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Контроллер страниц сущности "Авторизированный пользователь"
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * Роут страницы со всеми
     */
    public function getAll(PaginateRequest $request): View
    {
        $models = $this->userRepository->getAll((int) $request->get('page') ?? 1);

        return view('admin.users', compact('models'));
    }

    /**
     * Роут страницы с результатами поиска
     */
    public function search(Request $request): View
    {
        $models = $this->userRepository->searchByQuery($request->get('query') ?? '');

        return view('admin.users', compact('models'));
    }
}
