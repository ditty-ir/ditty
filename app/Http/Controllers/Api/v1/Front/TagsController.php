<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Models\Post;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostsRepository;

class TagsController extends Controller
{
    public function index(PostsRepository $posts, $tag)
    {
        $tag = clean($tag);
        return Response::success('', $posts->getByTag($tag));
    }
}
