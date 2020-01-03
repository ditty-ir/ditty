<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $post = new Post;

        $this->validate($request, [
            'q' => 'required|string|max:255'
        ]);

        return $post::where('title', 'like', "%{$request->q}%")
            ->orderBy('id', 'desc')
            ->select($post->necessaryFields())
            ->limit(50)
            ->get();
    }
}
