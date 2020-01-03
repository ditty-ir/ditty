<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Repositories\PostsRepository;

class ShortLinkController extends Controller
{
    public function index(PostsRepository $posts, $hashId)
    {
        if ($post_id = get_post_id($hashId)) {
            $post = $posts->find($post_id);
            if ($post) {
                return redirect($post->url);
            }
        }

        return abort(404);
    }
}
