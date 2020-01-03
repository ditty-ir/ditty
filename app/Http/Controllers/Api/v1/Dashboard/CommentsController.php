<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Models\Post;
use App\Models\Comment;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsRequest;
use App\Repositories\CommentsRepository;
use Illuminate\Database\Eloquent\Builder;

class CommentsController extends Controller
{

    private $comments;

    public function __construct(CommentsRepository $comments)
    {
        $this->comments = $comments;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::success('', $this->comments->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentsRequest $request, Post $post)
    {
        $comment = new $this->comments->model($request->only(
            $this->comments->getFillable()
        ));

        $post->comments()->save($comment);

        return Response::success('Created Successfully', $comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, ['text' => 'required']);

        $comment = $this->comments->update($comment, $request->only(
            $this->comments->getFillable()
        ));

        return Response::success('Edited Successfully', $comment->load('commentable'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        $comment->delete();

        return Response::success('deleted successfully');
    }
}
