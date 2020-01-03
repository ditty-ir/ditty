<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
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
            'title' => 'required|string|max:1024',
            'slug' => 'nullable|string|max:191',
            'category_id' => 'required|integer|exists:post_categories,id',
            'brief_text' => 'nullable|string|max:1024',
            'text' => 'required|string',
            'cover_image' => 'nullable|image',
            // 'status' => 'required|in:' . implode(',', array_keys(config('constants.post_statuses'))),
        ];
    }
}
