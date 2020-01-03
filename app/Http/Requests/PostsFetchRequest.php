<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsFetchRequest extends FormRequest
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
            'category_id' => 'nullable|integer|between:1,10000',
            'username' => 'bail|nullable|string|min:3|max:32|distinct:ignore_case|regex:/^[A-Za-z][A-Za-z0-9_]*(?:_[A-Za-z0-9]+)*$/',
        ];
    }
}
