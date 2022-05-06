<?php

namespace App\Http\Requests\Step;

use Illuminate\Foundation\Http\FormRequest;

class StoreStepRequest extends FormRequest
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
            'send_sms' => 'required',
            'service_template_id' => 'nullable|integer',
            'requirement_template_id' => 'nullable|integer',
            'project_id' => 'required|integer'
        ];
    }
}
