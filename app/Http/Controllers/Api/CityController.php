<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountyResource;
use App\Http\Resources\ProvinceResource;
use App\Models\City;
use App\Models\County;
use App\Models\Province;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexProvinces(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProvinceResource::collection(
            Province::get()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexCounties(Province $province): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CountyResource::collection(
            $province->counties()->get()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexCities(County $county): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CityResource::collection(
            $county->cities()->get()
        );
    }

    public function showCity(City $city): CityResource
    {
        return new CityResource(
            $city->load('county.province')
        );
    }
}
