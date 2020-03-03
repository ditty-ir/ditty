<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Models\Post;
use App\Classes\Draft;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Requests\PostsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostsRepository;
use App\Http\Requests\Dashboard\PostsSearchRequest;

class PostsController extends Controller
{

    private $posts;

    public function __construct(PostsRepository $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostsSearchRequest $request)
    {
        $posts = Auth::user()->isAdmin()
            ? $this->posts->search($request)
            : $this->posts->getByUserId(Auth::id(), 10, 0);

        return Response::success('', $posts);
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
    public function store(PostsRequest $request)
    {
        $post = $this->posts->create($request->only(
            $this->posts->getFillable()
        ));

        (new Draft)->deleteDraft();

        return Response::success('پست با موفقیت اضافه شد', $post->load('tagged'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Response::success('', $post->load('tagged'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, Post $post)
    {
        if ($this->hasPrivileges($post)) {
            $post = $this->posts->update($post, $request->only(
                $this->posts->getFillable()
            ));

            $post->retag($request->input('tags'));

            return Response::success('پست با موفقیت ویراش شد', $post->load('tagged'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($this->hasPrivileges($post)) {
            $post->delete();

            return Response::success('پست با موفقیت حذف شد');
        }
    }

    public function saveDraft(Request $request)
    {
        (new Draft)->save($request->except('cover_image'));

        return Response::success('Saved.');
    }

    public function getDraft()
    {
        return Response::success('', (new Draft)->get());
    }

    private function hasPrivileges($post)
    {
        return Auth::user()->isAdmin() || $post->user_id === Auth::id();
    }

    public function published()
    {
        return response()->success('', $this->posts->published());
    }
}
