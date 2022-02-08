<?php

namespace App\Services\Filter\Model;

use App\Services\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RequirementFilter extends AbstractFilter
{

    public static function build(Request $request, array $filters, $mapFilter = null): RequirementFilter
    {
        return new RequirementFilter($request, $filters);
    }

    protected static function filterElement(Builder $builder, $filter, $value): Builder
    {
        return $builder->where($filter, 'LIKE', "%$value%");
    }

    protected static function filterRelationElement(Builder $builder, $filter, $value, $relation): Builder
    {
        return $builder->whereHas($relation, function ($query) use ($filter, $value) {
            return $query->where($filter, 'LIKE', "%$value%");
        });
    }
}
