<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Enums\LinkResourceType;
use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Репозитоий сущности "Добавленная ссылка" @see Link
 *
 * @method Link getOneById(int $id, bool $force = false)
 * @method Link createByParams(array $params)
 * @method Link updateByParams(Model $model, array $params)
 * @method Link getAll(int $page = 1, int $pageLimit = 0)
 * @method Link searchByQuery(string $query, int $searchLimit = self::SEARCH_LIMIT)
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
     *  Получение вместе со ресурсами
     */
    public function getOneByIdWithResources(int $id, bool $force = false): Link
    {
        $link = $this->getOneById($id, $force);

        $resources = $this->findResources($link->resources, $force);

        /** @var Collection $resources */
        $link->resources = array_map(function ($resource) use ($resources) {
            return $resources->find($resource);
        }, $link->resources);

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

    public function addToFolder(Link $link, Link $added): void
    {
        if ($added->resourceType !== LinkResourceType::TO_GROUP) {
            $added->resources['folder'] = $link->id;
            $link->resources['urls'][]  = $added->id;

            $this->addResource($link, $added);
        }
    }

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

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
