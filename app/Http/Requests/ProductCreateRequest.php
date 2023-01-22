<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product.name' => 'required|string',
            'product.product_category_id' => 'required|uuid',
            'product.image' => 'required|string',
            'product.value' => 'required|integer',
            'product.cost' => 'required|integer',
            'product_stock' => 'required|integer',
            'product_informations' => 'array',
            'product_informations.*.name' => 'required|string',
            'product_informations.*.description' => 'required|string',
        ];
    }
}
