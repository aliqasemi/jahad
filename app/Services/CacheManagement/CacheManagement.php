<?php

namespace App\Services\CacheManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheManagement
{
    public static function buildList(Model $model, $relation = [], $relationCount = [], $params = null)
    {
        return Cache::remember($model::getCacheName(), 30000, function () use ($params, $relationCount, $relation, $model) {
            return $model->with($relation)->withCount($relationCount)->paginate();
        });
    }

    public static function buildItem(Model $model, int $modelId, $relation = [], $relationCount = [])
    {
        return Cache::remember($model::getCacheName() . $modelId, 30000, function () use ($modelId, $relationCount, $relation, $model) {
            return $model->findOrFail($modelId)->load(['main_image', 'category', 'city.county.province', 'user'])->loadCount($relationCount);
        });
    }

    protected static function pop(Model $model, int $modelId = null)
    {
        return Cache::forget($model::getCacheName() . $modelId);
    }

    public static function popItems(Model $model, int $modelId = null)
    {
        if (!(is_null($modelId))) {
            self::pop($model, $modelId);
        }
        self::pop($model);
    }
}
