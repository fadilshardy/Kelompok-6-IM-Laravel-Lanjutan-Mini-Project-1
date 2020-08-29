<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => ['alpha_num', 'required', 'min:3', 'max:25', 'unique:users,username'],
            'email' => ['email', 'required', 'min:3', 'max:25', 'unique:users,email'],
            'name' => ['required', 'min:5', 'max:25'],
            'password' => ['required', 'min:6', 'max:15'],
            'phone' => ['required', 'min:10', 'max:14', 'unique:users,phone'],
        ];
    }
}
