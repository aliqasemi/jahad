<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\StoreTemplateRequest;
use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return TemplateResource::collection(
            Template::get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTemplateRequest $request
     * @return TemplateResource
     */
    public function store(StoreTemplateRequest $request): TemplateResource
    {
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
     * @return TemplateResource
     */
    public function show(Template $template): TemplateResource
    {
        return new TemplateResource(
            $template
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTemplateRequest $request
     * @param \App\Models\Template $template
     * @return TemplateResource
     */
    public function update(UpdateTemplateRequest $request, Template $template): TemplateResource
    {
        $template = $template->fill($request->validated());

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
        $template->delete();
        return response('ok');
    }
}
