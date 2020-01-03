<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UsersRepository;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{

    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function show()
    {
        return Response::success('', $this->users->find(Auth::id()));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $this->users->update(Auth::user(), $request->only(
            $this->users->getFillable()
        ));

        Return Response::success('Profile updated successfully', $user);
    }
}
