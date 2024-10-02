<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Enums\LinkResourceType;
use App\Helpers\CacheHelper;
use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Репозитоий сущности "Добавленная ссылка" @see Link
 *
 * @method Link getOneById(int $id, bool $force = false)
 * @method Link createByParams(array $params)
 * @method getAll(int $page = 1, int $pageLimit = 0)
 * @method searchByQuery(string $query, int    $searchLimit = self::SEARCH_LIMIT, int    $page = 1, int    $pageLimit = self::PAGE_LIMIT)
 */
class LinkRepository extends AbstractRepository
{
    protected const MODEL = Link::class;

    protected const SEARCH_LIMIT = 9;

    protected const FULL_TEXT_SEARCHABLE_FIELDS = [
        'shortUrl',
    ];

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
     *  Получение вместе с ресурсами
     */
    public function getOneByIdWithResources(int $id, bool $force = false): Link
    {
        if (CacheHelper::has(Link::class, $id)) {
            $link = CacheHelper::get(Link::class, $id);
        } else {
            $link = $this->getOneById($id, $force);
        }

        $resources = $this->findResources($link->resources, $force);

        /** @var Collection $resources */
        $link->resources = array_map(function ($resource) use ($resources) {
            return $resources->find($resource);
        }, $link->resources);

        CacheHelper::set($link);

        return $link;
    }

    /**
     * Получение ресурсов
     */
    public function findResources(array $resources, bool $force = false): array
    {
        $builder = ($force)
            ? $this::MODEL::withTrashed()
            : $this::MODEL::query();

        foreach ($resources as $resource) {
            if (is_array($resource)) {
                $builder->orWhereIn('id', $resource);
            } else {
                $builder->orWhere(['id' => $resource]);
            };
        }

        return $builder->get();
    }

    /**
     * Добавление в папку
     */
    public function addToFolder(Link $link, Link $added): void
    {
        if ($added->resourceType !== LinkResourceType::TO_GROUP) {
            $added->resources['folder'] = $link->id;
            $link->resources['urls'][]  = $added->id;

            $this->addResource($link, $added);
        }
    }

    /**
     * Добавление группы
     */
    public function addGroup(Link $link, Link $added): void
    {
        if ($link->resourceType !== LinkResourceType::TO_FOLDER) {
            $link->resources['groups'] = $added->id;
            $added->resources['urls']  = $link->id;

            $this->addResource($link, $added);
        }
    }

    /**
     * Добавление ресурса
     */
    private function addResource(Link $link, Link $added): void
    {
        try {
            DB::beginTransaction();

            $added->save();
            $link->save();

            CacheHelper::delete(Link::class, $added->id);
            CacheHelper::delete(Link::class, $link->id);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Изменение
     */
    public function updateByParams(Model $model, array $params): Link
    {
        /** @var Link $model */
        CacheHelper::delete(Link::class, $model->id);

        /** @var Link $link */
        $link = parent::updateByParams($model, $params);

        return $link;
    }
}
