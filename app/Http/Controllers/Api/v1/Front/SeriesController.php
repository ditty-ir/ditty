<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Models\Post;
use App\Models\SeriesPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SeriesController extends Controller
{

    public function show($id)
    {
        $posts = Cache::remember('series_' . $id, 3600, function() use($id) {
            $posts_ids = SeriesPost::where('series_id', $id)->orderBy('id', 'desc')->get()->pluck('post_id');

            if ($posts_ids->count() > 0) {
                return Post::whereIn('id', $posts_ids)->select('id', 'title', 'slug')->get();
            }
        });

        return response()->success('', ! is_null($posts) ? $posts : []);
    }
}
