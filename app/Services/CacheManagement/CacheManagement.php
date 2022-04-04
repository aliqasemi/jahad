<?php

namespace App\Services\CacheManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class CacheManagement
{
    public static function buildList(Model $model, $relation = [], $relationCount = [], $params = null)
    {
        return Cache::remember($model::getCacheName() . 'page' . (Arr::get($params, 'page')), 30000, function () use ($params, $relationCount, $relation, $model) {
            return $model->with($relation)->withCount($relationCount)->paginate(Arr::get($params, 'per_page'), ['*'], 'page', Arr::get($params, 'page'));
        });
    }

    public static function buildItem(Model $model, int $modelId, $relation = [], $relationCount = [])
    {
        return Cache::remember($model::getCacheName() . $modelId, 30000, function () use ($modelId, $relationCount, $relation, $model) {
            return $model->findOrFail($modelId)->load($relation)->loadCount($relationCount);
        });
    }

    protected static function pop(Model $model, int $modelId = null)
    {
        if (is_null($modelId)) {
            $perPage = 1;
            while (!is_null(Cache::get($model::getCacheName() . 'page' . $perPage))) {
                Cache::forget($model::getCacheName() . 'page' . $perPage++);
            }
        } else {
            Cache::forget($model::getCacheName() . $modelId);
        }
    }

    public static function popItems(Model $model, int $modelId = null)
    {
        if (!(is_null($modelId))) {
            self::pop($model, $modelId);
        }
        self::pop($model);
    }
}
