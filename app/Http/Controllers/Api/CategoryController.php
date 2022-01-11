<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Services\CacheManagement;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CategoryResource::collection(
            CacheManagement::build(Category::getModel())->withCount(['descendants', 'children'])->get()->toTree()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = new Category($request->all());
        $category->save();
        CacheManagement::build(Category::getModel());

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource(
            CacheManagement::build(Category::getModel(), $category->id)->descendantsAndSelf($category->id)
                ->loadCount(['descendants', 'children'])
                ->toTree()
                ->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return CategoryResource
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category->fill($request->all());
        $category->save();
        CacheManagement::reBuild(Category::getModel(), $category->id);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category): Response
    {
        $category->delete();
        CacheManagement::reBuild(Category::getModel(), $category->id);
        return response('عملیات با موفقیت انجام شد');
    }
}
