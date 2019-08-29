<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'sku'          => 'string|unique:products',
            'slug'         => 'string|unique:products',
            'name'         => 'string',
            'photo'        => 'image|max:2048',
            'description'  => 'string',
            'price'        => 'numeric',
            'stock'        => 'numeric',
            'is_active'    => 'boolean',
        ];
    }
}
