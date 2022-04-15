<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CheckRelation\CheckProductAttachRelation;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequireProduct\AttachRequireProductRequest;
use App\Http\Resources\RequireProductResource;
use App\Models\BranchProduct;
use App\Models\Project;
use App\Models\RequireProduct;
use App\Models\RequireProductProduct;
use Illuminate\Support\Arr;

class RequireProductController extends Controller
{
    use CheckProductAttachRelation;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Project $project)
    {
        $this->authorize('viewAttachment', RequireProduct::class);

        return RequireProductResource::collection(
            RequireProduct::where('project_id', $project->id)->with([
                'productRequireProduct' => function ($query) {
                    return $query->with(['product', 'branch']);
                }])
                ->get()
        );
    }

    public function attach(RequireProduct $requireProduct, AttachRequireProductRequest $request)
    {
        $this->authorize('attach', RequireProduct::class);

        if ($this->canAttach($request->validated())) {
            foreach (Arr::get($request->validated(), 'products') as $product) {
                $diffNumber = 0;
                if ($productRequireProduct = $requireProduct->productRequireProduct()->find(Arr::get($product, 'id'))) {
                    $diffNumber = Arr::get($product, 'number') - $productRequireProduct->number;
                } else {
                    $diffNumber = Arr::get($product, 'number');
                }

                $requireProduct->productRequireProduct()->updateOrCreate(
                    ['id' => Arr::get($product, 'id')],
                    $product);

                $branchProduct = BranchProduct::where('product_id', Arr::get($product, 'product_id'))->where('branch_id', Arr::get($product, 'branch_id'))->first();

                $branchProduct->update([
                    'stock' => $branchProduct->stock - $diffNumber
                ]);
            }

            return new RequireProductResource(
                $requireProduct->load(['productRequireProduct', 'products', 'project'])
            );
        } else {
            return response('مقادیر اعطا شده به محصول بیشتر از موجودی انبار است', 422);
        }
    }

    public function destroy(RequireProductProduct $requireProductProduct)
    {
        $this->authorize('delete', RequireProduct::class);

        $branchProduct = BranchProduct::where('product_id', Arr::get($requireProductProduct, 'product_id'))
            ->where('branch_id', Arr::get($requireProductProduct, 'branch_id'))->first();

        $branchProduct->update([
            'stock' => $branchProduct->stock + Arr::get($requireProductProduct, 'number')
        ]);

        $requireProductProduct->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
