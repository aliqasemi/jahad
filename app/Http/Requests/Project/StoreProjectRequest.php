<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'timeout' => 'nullable|date',
            'services' => 'required|array',
            'services.*.id' => 'required|integer|exists:services,id',
            'requirement_id' => 'required|integer',
            'step_id' => 'nullable|integer',
            'require_products' => 'nullable|array',
            'require_products.*.name' => 'required|string',
            'require_products.*.description' => 'required|string',
            'require_products.*.number' => 'required|integer',
        ];
    }
}
