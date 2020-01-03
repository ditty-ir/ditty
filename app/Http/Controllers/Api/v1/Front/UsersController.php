<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function show(Request $request, UsersRepository $users)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'bail|required|string|min:3|max:32|distinct:ignore_case|regex:/^[A-Za-z][A-Za-z0-9_]*(?:_[A-Za-z0-9]+)*$/',
        ]);

        if (! $validator->fails()) {
            $user = $users->findByUsername($request->username);

            if (!empty($user)) {
                return Response::success('', $user);
            }
        }

        return Response::error('User not found.', 404);
    }
}
