<?php

namespace App\Http\Requests;

use App\EnumTypes\UFEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SearchRequest extends FormRequest
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
            'name' => 'string',
            'UF' => ['string', 'max:2', new Enum(UFEnum::class)],
            'city' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The name must be a string',
            'UF.string' => 'The state must be a string',
            'UF.max' => 'The state must be maximum 2 characters',
            'UF.enum' => 'Invalid state',
            'city.string' => 'The city must be a string'
        ];
    }
}
