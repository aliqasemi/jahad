<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'cell_number' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'city_id' => 'nullable|integer',
        ];
    }
}
