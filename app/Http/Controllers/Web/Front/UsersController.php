<?php

namespace App\Http\Controllers\Web\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;

class UsersController extends Controller
{
    public function index(UsersRepository $users, $username)
    {
        if ($user = $users->firstBy('username', $username)) {
            if ($user->isAuthor()) {
                return view('front.main');
            }
        }

        return response()->view('front.main', [
            'httpCode' => 404
        ], 404);

    }
}
