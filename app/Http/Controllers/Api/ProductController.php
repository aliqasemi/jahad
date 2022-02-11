<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CheckTemplateRelation;
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
            Product::with(['main_image'])->paginate(request('per_page'))
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

        return new ProductResource($product->load(['main_image']));
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
            $product->load(['main_image'])
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
        $product->main_image()->delete();
        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $product->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $product->save();
        return new ProductResource($product->load(['main_image']));
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
}
