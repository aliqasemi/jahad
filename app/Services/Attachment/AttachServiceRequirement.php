<?php

namespace App\Services\Attachment;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Arr;

class AttachServiceRequirement
{
    private $categoriesIndex = [];

    public static function build(Service $service): array
    {
        return (new static())->attach($service);
    }

    public function attach(Service $service): array
    {
        $map = [];
        if (!is_null($category = $service->category()->first())) {
            $map['0'] = $this->processSameLevel($category);

            $this->processTree(Arr::get(Category::descendantsAndSelf($category->id)->toTree()->first()->toArray(), 'children'));

            foreach ($this->categoriesIndex as $key => $categories) {
                $indexValue = [];
                foreach ($categories as $category) {
                    $category = Category::findOrfail(Arr::get($category, 'id'));
                    $requirements = $category->requirements()->with(['user', 'city', 'category'])->get()->toArray();
                    foreach ($requirements as $requirement) {
                        $indexValue[] = $requirement;
                    }
                }
                $map[$key] = $indexValue;
            }
        }
        return $this->attachPoint($map);
    }

    private function processSameLevel($category): array
    {
        $arrayByIndex = [];
        $requirements = $category->requirements()->with(['user', 'city', 'category'])->get()->toArray();
        foreach ($requirements as $requirement) {
            $arrayByIndex[] = $requirement;
        }
        return $arrayByIndex;
    }

    private function processTree(array $categories, int $index = 1): void
    {
        foreach ($categories as $category) {
            $this->categoriesIndex[$index][] = Arr::except($category, 'children');
            if (count(Arr::get(Category::descendantsAndSelf(Arr::get($category, 'id'))->toTree()->first()->toArray(), 'children'))) {
                $this->processTree(Arr::get(Category::descendantsAndSelf(Arr::get($category, 'id'))->toTree()->first()->toArray(), 'children'), $index + 1);
            }
        }
    }

    private function attachPoint(array $map): array
    {
        foreach ($map as $key => $value) {
            $map[$key]['point'] = count($map) - $key;
        }
        return $map;
    }
}
