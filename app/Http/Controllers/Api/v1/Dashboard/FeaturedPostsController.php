<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Models\Post;
use App\Classes\Response;
use App\Models\FeaturedPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturedPostsController extends Controller
{
    public function add(Post $post)
    {
        $exists = FeaturedPost::where('post_id', $post->id)->exists();

        if (! $exists) {
            $featuredPost = FeaturedPost::create([
                'post_id' => $post->id
            ]);

            return Response::success('', $featuredPost);
        }

        return Response::error('Already exists.', 400);
    }

    public function remove(Post $post)
    {
        $delete = FeaturedPost::where('post_id', $post->id)->limit(1)->delete();

        if ($delete) {
            return Response::success('Removed Successfully');
        }

        return Response::success('The post may not exist.');
    }
}
