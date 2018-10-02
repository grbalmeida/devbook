<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivacyRequest extends FormRequest
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
            'friends_list' => 'integer|between:1,3',
            'frienship_request' => 'integer|between:0,1',
            'posts' => 'integer|between:1,3'
        ];
    }

    public function messages()
    {
        $message = 'Informe um valor válido';
        return [
            'friends_list.between' => $message,
            'friendship_request.between' => $message,
            'posts.between' => $message,
            'friends_list.integer' => $message,
            'frienship_request.integer' => $message,
            'posts.integer' => $message,
        ];
    }
}
