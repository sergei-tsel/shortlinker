<?php
declare(strict_types=1);
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Абстрактный репозиторий
 */
abstract class AbstractRepository
{
    protected const MODEL = Model::class;

    protected const PAGE_LIMIT = 9;

    protected const SEARCH_LIMIT = 3;

    protected const FULL_TEXT_SEARCHABLE_FIELDS = [];

    public function getOneById(int $id, bool $force = false): Model
    {
        $builder = ($force)
            ? $this::MODEL::withTrashed()
            : $this::MODEL::query();

        return $builder->findOrFail($id);
    }

    public function createByParams(array $params): Model
    {
        $model = new ($this::MODEL);

        return $this->updateByParams($model, $params);
    }

    public function updateByParams(Model $model, array $params): Model
    {
        foreach ($params as $key => $value) {
            $model->$key = $value;
        }

        $model->save();

        return $model;
    }

    public function delete(Model|int $entity): void
    {
        if ($entity instanceof Model) {
            $entity->delete();
        } else {
            ($this::MODEL)->query()->where(['id' => $entity])->delete();
        }
    }

    public function restore(Model|int $entity): void
    {
        if ($entity instanceof Model) {
            $entity->restore();
        } else {
            ($this::MODEL)->query()->where(['id' => $entity])->restore();
        }
    }

    public function getAll(int $page = 1, int $pageLimit = 0): LengthAwarePaginator
    {
        $pageLimit = $pageLimit ?: static::PAGE_LIMIT;

        return $this::MODEL::query()
            ->orderByDesc('created_at')
            ->paginate(
                perPage: $pageLimit,
                page: $page,
            );
    }

    public function searchByQuery(
        string $query,
        int    $searchLimit = self::SEARCH_LIMIT,
        int    $page = 1,
        int    $pageLimit = self::PAGE_LIMIT,
    ): LengthAwarePaginator
    {
        $query = trim($query);

        $builder = $this::MODEL::withTrashed()->limit($searchLimit);

        if (!$query) {
            return new LengthAwarePaginator(new Collection(), 0, $pageLimit);
        }

        if (is_numeric($query)) {
            $builder->orWhere(['id' => $query]);
        }

        foreach ($this::FULL_TEXT_SEARCHABLE_FIELDS as $field) {
            $builder->orWhere($field, 'LIKE', "%$query%");
        }

        $builder->orderByDesc('updated_at');

        $results = $builder->get();

        return new LengthAwarePaginator (
            items: $results,
            total: count($results),
            perPage: $pageLimit,
            currentPage: $page,
        );
    }
}
