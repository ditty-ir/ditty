<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $user = $this->route()->parameter('user');

        if (empty($user)) {
            $user = Auth::user();
        }

        return [
            "name" => "required|string",
            "username" => "required|unique:users,username," . $user->id . ',id',
            "email" => "required|email|unique:users,email," . $user->id . ',id',
            "credentials" => 'nullable|string|max:191',
            "social_urls" => 'nullable|array',
            "avatar" => "nullable|image",
            "biography" => "nullable|string",
            "password" => "nullable|min:6|confirmed"
        ];
    }
}
