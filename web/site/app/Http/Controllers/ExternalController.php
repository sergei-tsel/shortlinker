<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Repositories\LinkRepository;
use App\Services\AwayLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Контроллер для перехода на внешний сайт
 */
class ExternalController extends Controller
{
    /**
     * Перейти по внешней ссылке
     */
    public function getAway(string $shortUrl): RedirectResponse
    {
        $link = (new LinkRepository())->getOneByShortUrl($shortUrl);

        $url = (new AwayLinkService())->getCheckedUrl($link);

        return redirect()->away($url);
    }

    /**
     * Получить внешние ссылки для перехода
     */
    public function getManyUrlsToAway(string $shortUrl): View
    {
        $link = (new LinkRepository())->getOneByShortUrl($shortUrl);

        $link = (new LinkRepository())->getOneWithResources($link);

        $urls = (new AwayLinkService())->getCheckedUrls($link);

        return view('link.resources', compact('link','urls'));
    }
}
