<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Репозиторий сущности  "Авторизированный пользователь" @see User
 *
 * @method User getOneById(int $id, bool $force = false)
 * @method User createByParams(array $params)
 * @method User updateByParams(Model $model, array $params)
 * @method User getAll(int $page = 1, int $pageLimit = 0)
 * @method User searchByQuery(string $query, int $searchLimit = self::SEARCH_LIMIT)
 */
class UserRepository extends AbstractRepository
{
    protected const MODEL = User::class;

    protected const PAGE_LIMIT = 3;

    protected const FULL_TEXT_SEARCHABLE_FIELDS = [
        'nickname',
    ];
}
