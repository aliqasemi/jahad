<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'city_id' => 'required|integer|exists:cities,id',
            'address' => 'required|string',
            'available_province_ids' => 'nullable|array',
            'available_province_ids.*' => 'required|string',
        ];
    }
}
