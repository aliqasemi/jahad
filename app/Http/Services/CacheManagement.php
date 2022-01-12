<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheManagement
{
    public static function buildList(Model $model, $relation = [], $relationCount = [])
    {
        return Cache::remember($model::getCacheName(), 30000, function () use ($relationCount, $relation, $model) {
            return $model->with($relation)->withCount($relationCount)->get();
        });
    }

    public static function buildItem(Model $model, int $modelId, $relation = [], $relationCount = [])
    {
        return Cache::remember($model::getCacheName() . $modelId, 30000, function () use ($modelId, $relationCount, $relation, $model) {
            return $model->findOrFail($modelId)->load($relation)->loadCount($relationCount)->get();
        });
    }

    protected static function pop(Model $model, int $modelId = null)
    {
        return Cache::forget($model::getCacheName() . $modelId);
    }

    public static function reBuild(Model $model, int $modelId = null, $relation = [], $relationCount = [])
    {
        if (!(is_null($modelId))) {
            self::pop($model, $modelId);
            self::buildItem($model, $modelId, $relation, $relationCount);
        }
        self::pop($model);
        self::buildList($model, $relation, $relationCount);
    }
}
