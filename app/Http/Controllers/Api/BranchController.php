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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Branch::class);

        return BranchResource::collection(
            Branch::with(['city'])->paginate(request('per_page'), ['*'], 'page', request('page'))
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexFilter(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', Branch::class);

        return BranchResource::collection(
            Branch::filter(request())->with(['city'])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return BranchResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreBranchRequest $request)
    {
        $this->authorize('create', Branch::class);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Branch $branch)
    {
        $this->authorize('view', Branch::class);

        return new BranchResource($branch->load(['city', 'main_image']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return BranchResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $this->authorize('update', Branch::class);

        $branch = $branch->fill($request->validated());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $branch->main_image()->delete();
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Branch $branch)
    {
        $this->authorize('delete', Branch::class);

        $branch->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
