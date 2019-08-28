<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'sku'          => 'required|string|unique:products',
            'slug'         => 'required|string|unique:products',
            'name'         => 'required|string',
            'photo'        => 'required|image|max:2048',
            'description'  => 'required|string',
            'price'        => 'required|numeric',
            'stock'        => 'required|numeric',
            'is_active'    => 'boolean',
        ];
    }
}
