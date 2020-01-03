<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegiserRequest extends FormRequest
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
            'g-recaptcha-response' => 'required|captcha',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => 'bail|required|string|min:3|max:32|distinct:ignore_case|regex:/^[A-Za-z][A-Za-z0-9_]*(?:_[A-Za-z0-9]+)*$/|unique:users,username',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
