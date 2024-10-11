<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Enums\LinkResourceType;
use App\Helpers\CacheHelper;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Репозитоий сущности "Добавленная ссылка" @see Link
 *
 * @method Link createByParams(array $params)
 * @method restore(Model|int $entity)
 * @method getAll(int $page = 1, int $pageLimit = 0)
 * @method searchByQuery(string $query, int $searchLimit = self::SEARCH_LIMIT, int $page = 1, int $pageLimit = self::PAGE_LIMIT)
 */
class LinkRepository extends AbstractRepository
{
    protected const MODEL = Link::class;

    protected const SEARCH_LIMIT = 9;

    protected const FULL_TEXT_SEARCHABLE_FIELDS = [
        'shortUrl',
    ];

    public function getOneById(int $id, bool $force = false): Link
    {
        if (CacheHelper::has(Link::class, $id)) {
            /** @var Link $link */
            $link = CacheHelper::get(Link::class, $id);

            return $link;
        }  else {
            /** @var Link $link */
            $link = parent::getOneById($id, $force);

            CacheHelper::set($link);

            return $link;
        }
    }

    /**
     * Получение по короткой ссылке
     */
    public function getOneByShortUrl(string $shortUrl): Link
    {
        /** @var Link $link */
        $link = $this::MODEL::query()
            ->where('shortUrl', $shortUrl)
            ->firstOrFail();

        return $link;
    }

    /**
     *  Получение ссылок пользователя по типу ресурса
     */
    public function getByUser(User $user, LinkResourceType $resourceType): Collection
    {
        $builder = $user->links()->ofResourceType($resourceType);

        if ($resourceType === LinkResourceType::TO_URL || $resourceType === LinkResourceType::TO_FOLDER) {
            $folders = $user->links()->ofResourceType(LinkResourceType::TO_FOLDER)->get();

            $folders->each(function (Link $link) use (&$builder) {
                if ($link->resources !== null) {
                    $builder = $builder->whereNotIn('id', $link->resources->toArray());
                }
            });
        }

        return $builder->get();
    }

    /**
     * Получение ссылок пользователя для добавления по типу ресурса
     */
    public function getAvailableToAddByUser(
        User             $user,
        LinkResourceType $resourceType,
        Link             $currentLink,
        int              $fromId,
    ): Collection|null
    {
        $builder = $user->links()->ofResourceType($resourceType);

        $currentResources = new Collection([$currentLink->id, $fromId]);

        if ($resourceType === LinkResourceType::TO_FOLDER && $currentLink->resourceType === LinkResourceType::TO_FOLDER) {
            $currentLink->resources?->each(function (int $id) use (&$currentResources){
                $currentResources->push($id);
            });
        }

        if ($resourceType === LinkResourceType::TO_GROUP) {
            $groups = $user->links()->ofResourceType(LinkResourceType::TO_GROUP)->get();

            $groups->each(function (Link $link) use ($currentLink, &$currentResources){
                $key = $link->resources?->search($currentLink->id);

                if ($key || $key === 0) {
                    $currentResources->push($link->id);
                }
            });
        }

        $builder->whereNotIn('id', $currentResources);

        $links = $builder->get();

        return $links->count() === 0 ? null : $links;
    }

    /**
     *  Получение вместе с ресурсами
     */
    public function getOneWithResources(Link|int $entity): Link
    {
        if (!$entity instanceof Link) {
            $entity = $this->getOneById($entity);
        }

        if ($entity->resources !== null) {
            $entity->resources = $entity->resources->map(function (int $id) {
                return $this->getOneById($id);
            });
        }

        return $entity;
    }

    /**
     * Добавление ресурса
     */
    public function addResource(Link $link, int $addedId): void
    {
        if ($link->resources !== null) {
            $link->resources->push($addedId);
        } else {
            $link->resources = new Collection($addedId);
        }

        $link->save();

        CacheHelper::delete(Link::class, $link->id);
    }

    /**
     * Удаление ресурса
     */
    public function removeResource(Link $link, int $removedId): void
    {
        $link->resources = $link->resources->filter(function (int $id) use ($removedId) {
            return $id !== $removedId;
        });

        if ($link->resources->count() === 0) {
            $link->resources = null;
        }

        $link->save();

        CacheHelper::delete(Link::class, $link->id);
    }

    /**
     * Изменение
     */
    public function updateByParams(Model $model, array $params): Link
    {
        /** @var Link $link */
        $link = parent::updateByParams($model, $params);

        /** @var Link $model */
        CacheHelper::delete(Link::class, $link->id);

        return $link;
    }

    /**
     * Удаление
     */
    public function delete(Model|int $entity): void
    {
        if ($entity instanceof Link) {
            CacheHelper::delete(Link::class, $entity->id);
        } else {
            CacheHelper::delete(Link::class, $entity);
        }

        parent::delete($entity);
    }
}
