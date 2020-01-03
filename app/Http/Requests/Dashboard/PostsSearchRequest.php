<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PostsSearchRequest extends FormRequest
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
            // 'id' => 'nullable|integer',
            'title' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer',
            'status' => 'nullable|integer|in:1,2,3',
        ];
    }
}
