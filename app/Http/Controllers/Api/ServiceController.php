<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\User;
use App\Services\CacheManagement\CacheManagement;
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
    public function index()
    {
        $this->authorize('viewAny', Service::class);

//        return ServiceResource::collection(
//            CacheManagement::buildList(Service::getModel(), ['main_image', 'city.county.province', 'user', 'category'], [], ['per_page' => request('per_page'), 'page' => request('page')])
//        );

        return ServiceResource::collection(
            Service::query()->filter(request())->with(['main_image', 'city.county.province', 'user', 'category'])->paginate(request('per_page'), ['*'], 'page', request('page'))
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
        $this->authorize('create', Service::class);

        $user = User::findOrFail(Auth::id());
        $service = new Service($request->all());
        $user->services()->save($service);
        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $service->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        if (!is_null(Arr::get($request->all(), 'available_province_ids'))) {
            $service->available_province()->sync(Arr::get($request->all(), 'available_province_ids'));
        }

        $service->save();

        return new ServiceResource($service->load(['main_image', 'city.county.province', 'user', 'category', 'available_province']));
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return ServiceResource
     */
    public function show(Service $service): ServiceResource
    {
        $this->authorize('view', $service);

        return new ServiceResource(
            CacheManagement::buildItem(Service::getModel(), $service->id, ['main_image', 'category', 'city.county.province', 'user', 'available_province'], [])
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
        $this->authorize('update', $service);

        $service->fill($request->all());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $service->main_image()->delete();
            $service->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        if (!is_null(Arr::get($request->all(), 'available_province_ids'))) {
            $service->available_province()->sync(Arr::get($request->all(), 'available_province_ids'));
        }

        $service->save();

        return new ServiceResource($service->load(['main_image', 'category', 'city.county.province', 'user', 'available_province']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return Response
     */
    public function destroy(Service $service): Response
    {
        $this->authorize('delete', $service);

        $service->delete();
        return response(trans('messages.success_operation'));
    }
}
