<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Models\Post;
use App\Classes\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentsRequest;
use App\Repositories\CommentsRepository;
use Illuminate\Support\Facades\Cache;

class CommentsController extends Controller
{
    private $comments;

    public function __construct(CommentsRepository $comments)
    {
        $this->comments = $comments;
    }

    public function index($post_id)
    {
        $post = Post::where('id', get_post_id($post_id))->select('id')->firstOrFail();

        return Response::success('', $post->load('comments.user')->comments);
    }

    public function store(CommentsRequest $request, Post $post)
    {
        $isLogin = Auth::check();

        $comment = $this->comments->create([
            'text' => $request->text,
            'email' => $isLogin ? null : $request->email,
            'name' => $isLogin ? null : $request->name,
            'user_id' => $isLogin ? Auth::id() : null
        ]);

        $post->comments()->save($comment);

        return Response::success(
            'نظر شما با موفقیت ثبت شد و بعد از تایید نمایش داده میشه.',
            $comment->only(['text'])
        );
    }

    public function latest()
    {
        $comments = Cache::remember('latest_comments', 3600, function() {
            return $this->comments->latestApproved();
        });

        return Response::success('', $comments);
    }
}
