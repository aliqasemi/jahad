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
     */
    public function index()
    {
        return ProductResource::collection(
            Product::with(['main_image'])->paginate(request('per_page'), ['*'], 'page', request('page'))
        );
    }

    public function indexFilter(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::filter(request())->get()
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return ProductResource
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        $product = new Product($request->validated());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $product->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $product->save();

        if ($branches = Arr::get($request->all(), 'branches')) {
            $product->branches()->sync($this->prepareBranchesForSync($branches));
        }

        return new ProductResource($product->load(['main_image', 'branches']));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
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
     */
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $product = $product->fill($request->validated());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $product->main_image()->delete();
            $product->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $product->save();

        if ($branches = Arr::get($request->all(), 'branches')) {
            $product->branches()->sync($this->prepareBranchesForSync($branches));
        }

        return new ProductResource($product->load(['main_image', 'branches']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): \Illuminate\Http\Response
    {
        $product->delete();
        return response('عملیات با موفقیت انجام شد');
    }

    private function prepareBranchesForSync(array $branches): array
    {
        $result = [];

        foreach ($branches as $branch) {
            $result[$branch['branch_id']] = [
                'description' => $branch ['description'],
                'stock' => $branch ['stock']
            ];
        }

        return $result;
    }

}
