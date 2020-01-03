<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Post, User, Comment};

class StatsController extends Controller
{
    public function index()
    {
        return Response::success('', [
            'users' => User::count(),
            'comments' => Comment::where('status', Comment::STATUS_PENDING)->count(),
            'posts' => Post::where('status', Post::STATUS_PUBLISHED)->count()
        ]);
    }
}
