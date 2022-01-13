<?php

namespace App\Observers;

use App\Http\Services\CacheManagement;
use App\Http\Services\CategoryCacheManagement;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "saving" event.
     *
     * @param \App\Models\Category $category
     * @return void
     */
    public function saving(Category $category)
    {
        CategoryCacheManagement::popItems($category, $category->id);
        foreach (Category::$relationsCache as $relation) {
            $models = $category->$relation()->get();
            if (count($models)) {
                foreach ($models as $model) {
                    CacheManagement::popItems($model, $model->id);
                }
            }
        }
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param \App\Models\Category $category
     * @return void
     */
    public function deleted(Category $category)
    {
        CategoryCacheManagement::popItems($category, $category->id);
        foreach (Category::$relationsCache as $relation) {
            $models = $category->$relation()->get();
            if (count($models)) {
                foreach ($models as $model) {
                    CacheManagement::popItems($model, $model->id);
                }
            }
        }
    }
}
