<?php

namespace App\Http\Requests\RequireProduct;

use Illuminate\Foundation\Http\FormRequest;

class AttachRequireProductRequest extends FormRequest
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
            'products' => 'required|array',
            'products.*.id' => 'nullable|integer',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.branch_id' => 'required|integer|exists:branches,id',
            'products.*.number' => 'required|integer',
            'products.*.description' => 'nullable|string',
        ];
    }
}
