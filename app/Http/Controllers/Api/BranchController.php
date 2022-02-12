<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use Illuminate\Support\Arr;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BranchResource::collection(
            Branch::with(['city'])->paginate(request('per_page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return BranchResource
     */
    public function store(StoreBranchRequest $request)
    {
        $branch = new Branch($request->validated());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $branch->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $branch->save();

        return new BranchResource($branch->load(['city', 'main_image']));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Branch $branch
     * @return BranchResource
     */
    public function show(Branch $branch)
    {
        return new BranchResource($branch->load(['city', 'main_image']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return BranchResource
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch = $branch->fill($request->validated());

        $branch->main_image()->delete();
        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $branch->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $branch->save();

        return new BranchResource($branch->load(['city', 'main_image']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
