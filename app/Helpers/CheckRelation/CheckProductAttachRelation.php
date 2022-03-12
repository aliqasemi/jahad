<?php

namespace App\Helpers\CheckRelation;


use App\Models\BranchProduct;
use App\Models\Product;
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

                $requireProduct = Product::whereHas('branches', function ($query) use ($branchId, $productId, $diffNumber) {
                    return $query->where('branch_id', $branchId)->where('product_id', $productId)
                        ->selectRaw('product_id, branch_id, SUM(stock) as total_number')
                        ->groupBy(['branch_id', 'product_id'])
                        ->having('total_number', '>=', $diffNumber);
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
