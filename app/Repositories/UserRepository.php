<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * Репозиторий сущности  "Авторизированный пользователь" @see User
 *
 * @method User getOneById(int $id, bool $force = false)
 * @method User updateByParams(Model $model, array $params)
 * @method delete(Model|int $entity)
 * @method restore(Model|int $entity)
 * @method getAll(int $page = 1, int $pageLimit = 0)
 * @method searchByQuery(string $query, int $searchLimit = self::SEARCH_LIMIT, int $page = 1, int $pageLimit = self::PAGE_LIMIT)
 */
class UserRepository extends AbstractRepository
{
    protected const MODEL = User::class;

    protected const FULL_TEXT_SEARCHABLE_FIELDS = [
        'nickname',
    ];

    /**
     * Создание
     */
    public function createByParams(array $params): User
    {
        $params['password'] = Hash::make($params['password']);

        /** @var User $user */
        $user = parent::createByParams($params);

        return $user;
    }

    /**
     * Изменение пароля
     */
    public function changePassword(User $user, string $newPassword): User
    {
        /** @var User $user */
       $user = parent::updateByParams($user, [
           'password' => Hash::make($newPassword),
       ]);

       return $user;
    }
}
