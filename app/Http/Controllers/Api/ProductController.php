<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CheckRelation\CheckTemplateRelation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Arr;


class ProductController extends Controller
{
    use CheckTemplateRelation;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Product::class);

        return ProductResource::collection(
            Product::filter(request())->with(['main_image'])->withSum('branches', 'branch_product.stock')->paginate(request('per_page'), ['*'], 'page', request('page'))
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexFilter(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', Product::class);

        return ProductResource::collection(
            Product::filter(request())->get()
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return ProductResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        $this->authorize('create', Product::class);

        $product = new Product($request->validated());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $product->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $product->save();

        if ($branches = Arr::get($request->all(), 'branches')) {
            foreach ($branches as $branch) {
                $product->branches()->attach([
                        Arr::get($branch, 'branch_id') => [
                            'description' => Arr::has($branch, 'description') ? $branch ['description'] : null,
                            'stock' => $branch ['stock']
                        ]
                    ]
                );
            }
        }

        return new ProductResource($product->load(['main_image', 'branches']));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return ProductResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Product $product): ProductResource
    {
        $this->authorize('view', Product::class);

        return new ProductResource(
            $product->load(['main_image', 'branches'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @return ProductResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $this->authorize('update', Product::class);

        $product = $product->fill($request->validated());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $product->main_image()->delete();
            $product->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $product->save();

        $product->branches()->detach();

        if ($branches = Arr::get($request->all(), 'branches')) {
            foreach ($branches as $branch) {
                $product->branches()->attach([
                        Arr::get($branch, 'branch_id') => [
                            'description' => Arr::has($branch, 'description') ? $branch ['description'] : null,
                            'stock' => $branch ['stock']
                        ]
                    ]
                );
            }
        }

        return new ProductResource($product->load(['main_image', 'branches']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Product $product): \Illuminate\Http\Response
    {
        $this->authorize('delete', Product::class);

        $product->delete();
        return response(trans('messages.success_operation'));
    }

//    private function prepareBranchesForSync(array $branches): array
//    {
//        $result = [];
//
//        foreach ($branches as $branch) {
//            $result[$branch['branch_id']] = [
//                'description' => Arr::has($branch, 'description') ? $branch ['description'] : null,
//                'stock' => $branch ['stock']
//            ];
//        }
//
//        return $result;
//    }

}
