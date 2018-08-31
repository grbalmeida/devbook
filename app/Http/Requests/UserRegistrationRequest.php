<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|confirmed|unique:users|max:100',
            'password' => 'required|max:100',
            'gender' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Informe o nome',
            'first_name.max' => 'O nome deve conter no máximo 50 caracteres',
            'last_name.required' => 'Informe o sobrenome',
            'last_name.max' => 'O sobrenome deve conter no máximo 50 caracteres',
            'email.required' => 'Informe o e-mail',
            'email.email' => 'Informe um e-mail válido',
            'email.confirmed' => 'E-mails não correspondem',
            'email.max' => 'O e-mail deve conter no máximo 100 caracteres',
            'email.unique' => 'E-mail já cadastrado',
            'password.required' => 'Informe a senha',
            'gender.required' => 'Informe seu sexo'
        ];
    }

}
