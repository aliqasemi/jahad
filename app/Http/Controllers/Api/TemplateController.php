<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CheckRelation\CheckTemplateRelation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Template\StoreTemplateRequest;
use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    use CheckTemplateRelation;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', Template::class);

        return TemplateResource::collection(
            Template::filter(request())->get()
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexFilter(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', Template::class);

        return TemplateResource::collection(
            Template::filter(request())->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTemplateRequest $request
     * @return TemplateResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTemplateRequest $request): TemplateResource
    {
        $this->authorize('create', Template::class);

        $template = new Template($request->validated());

        $user = User::findOrFail(Auth::id());
        $user->templates()->save($template);

        return new TemplateResource(
            $template->load(['user'])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Template $template
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Template $template): array
    {
        $this->authorize('view', Template::class);

        if (in_array($template->id, Template::getDefaultTemplateIds())
        ) {
            return [
                'id' => $template->id,
                'name' => $template->name,
                'template' => $template->template,
                'variables' => Template::$TEMPLATE_VARIABLE['user_management'],
            ];
        } else {
            return [
                'id' => $template->id,
                'name' => $template->name,
                'template' => $template->template,
                'service_variables' => Template::$TEMPLATE_VARIABLE['service_management'],
                'requirement_variables' => Template::$TEMPLATE_VARIABLE['requirement_management'],
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTemplateRequest $request
     * @param \App\Models\Template $template
     * @return TemplateResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTemplateRequest $request, Template $template): TemplateResource
    {
        $this->authorize('update', Template::class);

        $template = $template->fill($request->validated());

        $template->save();

        return new TemplateResource(
            $template
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template): \Illuminate\Http\Response
    {
        $this->authorize('delete', Template::class);

        if ($this->canDelete($template)) {
            $template->delete();
            return response(trans('messages.success_operation'));
        } else {
            return response(trans('messages.template_during'));
        }
    }
}
