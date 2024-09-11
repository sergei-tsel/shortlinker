<?php
declare(strict_types=1);
namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    public function restore(Model|int $model): void
    {
        if ($model instanceof Model) {
            $model->restore();
        } else {
            ($this::MODEL)->query()->where(['id' => $model])->restore();
        }
    }

    public function getAll(int $page = 1, int $pageLimit = 0): LengthAwarePaginator
    {
        $pageLimit = $pageLimit ?: static::PAGE_LIMIT;

        return Model::query()
            ->orderByDesc('created_at')
            ->paginate(
                perPage: $pageLimit,
                page: $page,
            );
    }

    public function searchByQuery(string $query, int $searchLimit = self::SEARCH_LIMIT): Collection
    {
        $query = trim($query);

        if (!$query) {
            return new Collection();
        }

        $builder = Model::query()->limit($searchLimit);

        if (is_numeric($query)) {
            $builder->orWhere(['id' => $query]);
        }

        foreach ($this::FULL_TEXT_SEARCHABLE_FIELDS as $field) {
            $builder->orWhere($field, 'LIKE', "%$query%");
        }

        $builder->orderByDesc('updated_at');

        return $builder->get();
    }
}
