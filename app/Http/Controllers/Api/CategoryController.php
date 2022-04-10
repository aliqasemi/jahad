<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CacheManagement\CategoryCacheManagement;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Category::class);

        return CategoryResource::collection(
            CategoryCacheManagement::buildList(Category::getModel(), [], ['descendants', 'children'])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return CategoryResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $this->authorize('create', Category::class);

        $category = new Category($request->all());
        $category->save();

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Category $category)
    {
        $this->authorize('view', Category::class);

        return new CategoryResource(
            CategoryCacheManagement::buildItem(Category::getModel(), $category->id, [], ['descendants', 'children'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return CategoryResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $this->authorize('update', Category::class);

        $category->fill($request->all());
        $category->save();
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Category $category): Response
    {
        $this->authorize('delete', Category::class);

        $category->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
