<?php

namespace App\Http\Requests\Branch;

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
            'postal_code' => 'nullable',
            'cell_number' => 'nullable',
            'phone_number' => 'nullable',
            'city_id' => 'nullable|integer',
        ];
    }
}
