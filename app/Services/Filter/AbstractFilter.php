<?php

namespace App\Services\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class AbstractFilter
{
    protected $request;
    protected $filters = [];
    protected $relations;

    public function __construct(Request $request, array $filters, $mapFilter = null)
    {
        $this->request = $request;
        $this->filters = $filters;
        $this->relations = $mapFilter;
    }

    public function filter(Builder $builder)
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)::filterElement($builder, $filter, $value);
        }

        foreach ($this->getRelationFilter() as $filter => $value) {
            $relation = Arr::first(explode(':', Arr::first(array_keys($this->relations[$filter]))));
            $attribute = Arr::last(explode(':', Arr::first(array_keys($this->relations[$filter]))));
            $this->resolveRelationFilter($filter)::filterRelationElement($builder, $attribute, $value, $relation);
        }

        return $builder;
    }

    protected function getFilters(): array
    {
        return $this->request->only(array_keys($this->filters));
    }

    protected function getRelationFilter(): array
    {
        return $this->request->only(array_keys($this->relations));
    }

    protected function resolveFilter($filter)
    {
        return $this->filters[$filter];
    }

    protected function resolveRelationFilter($filter)
    {
        return Arr::first(array_values($this->relations[$filter]));
    }

    abstract protected static function filterElement(Builder $builder, $filter, $value): Builder;


    abstract protected static function filterRelationElement(Builder $builder, $filter, $value, $relation): Builder;
}