<?php

namespace App\Helpers\CheckRelation;


use App\Models\Product;
use App\Models\RequireProduct;
use App\Models\RequireProductProduct;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait CheckProductAttachRelation
{
    public function canAttach($data): bool
    {
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();

        foreach (collect(Arr::get($data, 'products'))->groupBy(['product_id', 'branch_id'])->toArray() as $productId => $value) {
            foreach ($value as $branchId => $items) {
                $diffNumber = 0;
                foreach ($items as $item) {
                    if (Arr::has($item, 'id') && RequireProductProduct::find(Arr::get($item, 'id'))) {
                        $diffNumber += (Arr::get($item, 'number') - RequireProductProduct::findOrFail(Arr::get($item, 'id'))->number);
                    } else {
                        $diffNumber += Arr::get($item, 'number');
                    }
                }

                $requireProduct = Product::whereIn('id', Arr::pluck(Arr::get($data, 'products'), 'product_id'))
                    ->whereHas('branches', function ($query) use ($data) {
                        $query->whereIn('branches.id', Arr::pluck(Arr::get($data, 'products'), 'branch_id'));
                    })
                    ->whereHas('branches', function ($query) use ($items, $branchId, $productId, $diffNumber) {
                        $sum = RequireProductProduct::where('branch_id', $branchId)
                            ->where('product_id', $productId)->sum('number');
                        return $query->selectRaw('product_id, branch_id, SUM(stock) as total_number')
                            ->groupBy(['branch_id', 'product_id'])
                            ->where('branch_id', $branchId)
                            ->where('product_id', $productId)
                            ->having('total_number', '>=', $diffNumber + $sum);
                    })
                    ->get();

                if (!count($requireProduct)) {
                    return false;
                }
            }
        }

        config()->set('database.connections.mysql.strict', true);
        DB::reconnect();

        return true;
    }
}
