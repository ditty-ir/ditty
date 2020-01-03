<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use App\Models\User;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use App\Http\Requests\ProfileUpdateRequest;

class UsersController extends Controller
{
    private $users;

    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        return Response::success('', $this->users());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        $item = $this->users->update($user, $request->only(
            $this->users->getFillable()
        ));

        $item->level = $request->level;
        $item->save();

        if ($request->filled('password')) {
            $item->revokeTokens();
        }

        $item->setHidden(['password', 'remember_token']);

        return Response::success('کاربر با موفقیت ویرایش شد', [
            'user' => $item
        ]);
    }

    private function users()
    {
        $users = $this->users->all();

        $users->each(function ($item) {
            $item->setHidden(['password', 'remember_token']); //->setVisible(['email']);
        });

        return $users;
    }
}
