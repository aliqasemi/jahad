<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheManagement
{
    public static function build(Model $model, int $modelId = null)
    {
        return Cache::remember($model::getCacheName() . $modelId, 30000, function () use ($model) {
            return $model;
        });
    }


    private static function pop(Model $model, int $modelId = null)
    {
        return Cache::forget($model::getCacheName() . $modelId);
    }

    public static function reBuild(Model $model, int $modelId = null)
    {
        if (!(is_null($modelId))) {
            self::pop($model, $modelId);
            self::build($model, $modelId);
        }
        self::pop($model);
        self::build($model);
    }
}
