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
 * Контроллер страниц
 */
class PageController extends Controller
{
    /**
     * Роут главной страницы
     */
    public function welcome(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $urls    = (new LinkRepository())->getByUser($user, LinkResourceType::TO_URL);
        $folders = (new LinkRepository())->getByUser($user, LinkResourceType::TO_FOLDER);
        $groups  = (new LinkRepository())->getByUser($user, LinkResourceType::TO_GROUP);

        return view('welcome', compact('user', 'urls', 'folders', 'groups'));
    }
}
