<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Models\Post;
use App\Classes\Response;
use App\Repositories\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostsRepository;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PostsFetchRequest;

class PostsController extends Controller
{
    private $posts;

    public function __construct(PostsRepository $posts)
    {
        $this->posts = $posts;
    }

    public function index(PostsFetchRequest $request)
    {
        $limit = 9;

        if ($request->filled('category_id')) {
            $posts = $this->posts->getByCategoryId($request->category_id, $limit);
        } else if ($request->filled('user_id')) {
            $posts = $this->posts->getByUserId($request->user_id, $limit);
        } else {
            $posts = $this->posts->paginate($limit);
        }

        return Response::success('', $posts);
    }

    public function homePosts()
    {
        return Response::success('', $this->posts->paginate(8));
    }

    public function show($post)
    {
        return Response::success(
            '',
            $post->loadCount('comments')->load('comments.user')
        );
    }

    public function getByPath(Pages $pages, $path)
    {
        if ($page = $pages->getByPath(clean($path))) {
            $post = $page->fullPost;

            return Response::success(
                '',
                $post->loadCount('comments')->load('comments.user')
            );
        } else {
            abort(404);
        }
    }

    public function relatedPosts(Post $post)
    {
        $posts = $this->posts->related($post);

        return Response::success('', $posts);
    }

    public function featured()
    {
        $posts = Cache::remember('featured_posts', 3600, function() {
            return $this->posts->featured();
        });

        return Response::success('', $posts);
    }
}
