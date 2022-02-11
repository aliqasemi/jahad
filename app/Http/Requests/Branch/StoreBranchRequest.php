<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'postal_code' => 'nullable|string',
            'cell_number' => 'required_without:phone_number|string',
            'phone_number' => 'required_without:cell_number|string',
            'city_id' => 'nullable|integer',
        ];
    }
}
