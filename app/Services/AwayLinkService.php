<?php
declare(strict_types=1);
namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;

/**
 * Сервис для получения внешних ссылок
 */
class AwayLinkService
{
    /**
     * Получение списка проверенных ссылок
     */
    public function getCheckedUrls(Link $link): array
    {
        return $link->resources
            ->map(function (Link $item) {
                return $this->getCheckedUrl($item);
            })
            ->prepend($this->getCheckedUrl($link))
            ->filter()
            ->all();
    }

    /**
     * Получение проверенной ссылки
     */
    public function getCheckedUrl(Link $link): string|null
    {
        if(Str::isUrl($link->longUrl)) {
            return $link->longUrl;
        } else {
            return null;
        }
    }
}
