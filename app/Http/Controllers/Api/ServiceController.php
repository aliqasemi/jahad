<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ServiceResource::collection(
            Service::with(['main_image', 'city.county.province', 'user', 'category'])->paginate(request('per_page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServiceRequest $request
     * @return ServiceResource
     */
    public function store(StoreServiceRequest $request): ServiceResource
    {
        $user = User::findOrFail(Auth::id());
        $service = new Service($request->all());
        $user->services()->save($service);
        if (Arr::has($request->all(), 'main_image')) {
            $service->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }
        $service->save();

        return new ServiceResource($service->load(['main_image', 'city.county.province', 'user', 'category']));
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return ServiceResource
     */
    public function show(Service $service): ServiceResource
    {
        return new ServiceResource(
            $service->load(['main_image', 'category', 'city.county.province', 'user'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServiceRequest $request
     * @param Service $service
     * @return ServiceResource
     */
    public function update(UpdateServiceRequest $request, Service $service): ServiceResource
    {
        $service->fill($request->all());
        if (Arr::has($request->all(), 'main_image')) {
            $service->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $service->save();

        return new ServiceResource($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return Response
     */
    public function destroy(Service $service): Response
    {
        $service->delete();
        return response('ok');
    }
}
