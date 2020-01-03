<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PostsRepository;

class RssController extends Controller
{
    public function index(PostsRepository $posts)
    {
        return response()->view('front.rss', [
            'posts' => $posts->published()
        ], 200, ['Content-type' => 'text/xml;charset=utf8']);
    }
}
