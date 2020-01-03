<?php
namespace App\Repositories;

use Illuminate\Http\Request;

class UsersRepository extends Repository
{
    public function model()
    {
        return \App\Models\User::class;
    }

    public function findByUsername($username)
    {
        return $this->model->where('username', $username)->first();
    }

}