<?php
declare(strict_types=1);
namespace App\Enums;

enum LinkResourceType: int
{
    case TO_URL = 1;

    case TO_FOLDER = 2;

    case TO_GROUP = 3;

    public static function values(): array
    {
        $list = self::cases();

        return array_map(function (self $item) {
            return $item->value;
        }, $list);
    }
}
