<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Requirement;
use Illuminate\Support\Arr;

class AttachRequirementService
{
    private $categoriesIndex = [];

    public static function build(Requirement $requirement): array
    {
        return (new static())->attach($requirement);
    }

    public function attach(Requirement $requirement): array
    {
        $map = [];
        if (!is_null($category = $requirement->category()->first())) {
            $map['0'] = $this->processSameLevel($category);

            $this->processTree(Arr::get(Category::descendantsAndSelf($category->id)->toTree()->first()->toArray(), 'children'));

            foreach ($this->categoriesIndex as $key => $categories) {
                $indexValue = [];
                foreach ($categories as $category) {
                    $category = Category::findOrfail(Arr::get($category, 'id'));
                    $services = $category->services()->with(['user', 'city', 'category'])->get()->toArray();
                    foreach ($services as $service) {
                        $indexValue[] = $service;
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
        $services = $category->services()->with(['user', 'city', 'category'])->get()->toArray();
        foreach ($services as $service) {
            $arrayByIndex[] = $service;
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
