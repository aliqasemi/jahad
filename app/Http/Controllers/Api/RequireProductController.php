<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CheckRelation\CheckProductAttachRelation;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequireProduct\AttachRequireProductRequest;
use App\Http\Resources\RequireProductResource;
use App\Models\Project;
use App\Models\RequireProduct;
use Illuminate\Support\Arr;

class RequireProductController extends Controller
{
    use CheckProductAttachRelation;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Project $project)
    {

        return RequireProductResource::collection(
            RequireProduct::where('project_id', $project->id)->with([
                'productRequireProduct' => function ($query) {
                    return $query->with(['product', 'branch']);
                }])
                ->get()
        );
    }

    public function attach(RequireProduct $requireProduct, AttachRequireProductRequest $request)
    {
        if ($this->canAttach($request->validated())) {
            foreach (Arr::get($request->validated(), 'products') as $product) {
                $requireProduct->productRequireProduct()->updateOrCreate(
                    ['id' => Arr::get($product, 'id')],
                    $product);
            }
        } else {
            return response('مقادیر اعطا شده به محصول بیشتر از موجودی انبار است');
        }
    }
}
