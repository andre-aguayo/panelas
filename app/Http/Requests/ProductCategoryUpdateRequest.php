<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryUpdateRequest extends FormRequest
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
            'id' => 'required|uuid',
            'name' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __(),
            'id.uuid' => __(),
            'name.required' => __(),
            'name.string' => __(),
        ];
    }
}
