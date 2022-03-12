<?php

namespace App\Services\Filter\Model;

use App\Services\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilter extends AbstractFilter
{

    public static function build(Request $request, array $filters, $mapFilter = null): ProductFilter
    {
        return new ProductFilter($request, $filters, $mapFilter);
    }

    protected static function filterElement(Builder $builder, $filter, $value, $isOr): Builder
    {
        if ($isOr) {
            return $builder->orWhere($filter, 'LIKE', "%$value%");
        } else {
            return $builder->where($filter, 'LIKE', "%$value%");
        }
    }

    protected static function filterRelationElement(Builder $builder, $filter, $value, $relation, $isOr): Builder
    {
        if ($isOr) {
            return $builder->orWhereHas($relation, function ($query) use ($filter, $value) {
                return $query->where($filter, 'LIKE', "%$value%");
            });
        } else {
            return $builder->whereHas($relation, function ($query) use ($filter, $value) {
                return $query->where($filter, 'LIKE', "%$value%");
            });
        }
    }
}
