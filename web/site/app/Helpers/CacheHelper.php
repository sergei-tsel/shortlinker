<?php
declare(strict_types=1);
namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Хелпер кеширования
 */
class CacheHelper
{
    /**
     * Получение ключа кеша
     */
    private static function getKey(string $entity, int $id): string
    {
        return $entity . '_' . $id;
    }

    /**
     * Получение кеша
     */
    public static function get(string $entity, int $id): Model|null
    {
        $cacheKey = self::getKey($entity, $id);

        return Cache::get($cacheKey);
    }

    /**
     * Сохранение кеша
     */
    public static function set(Model $model): void
    {
        $cacheKey = self::getKey($model::class, $model->id);

        Cache::set($cacheKey, $model);
    }

    /**
     * Удаление кеша
     */
    public static function delete(string $entity, int $id): void
    {
        $cacheKey = self::getKey($entity, $id);

        Cache::delete($cacheKey);
    }

    /**
     * Проверка наличия кеша
     */
    public static function has(string $entity, int $id): bool
    {
        $cacheKey = self::getKey($entity, $id);

        return Cache::has($cacheKey);
    }
}
