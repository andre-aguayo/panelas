<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
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
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'subject.required' => 'Subject is required',
            'subject.string' => 'Subject is invalid',
            'message.required' => 'Message is required',
            'message.string' => 'Message format is invalid'
        ];
    }
}
