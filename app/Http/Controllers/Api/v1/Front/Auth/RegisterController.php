<?php

namespace App\Http\Controllers\Api\v1\Front\Auth;

use Exception;
use App\Models\User;
use App\Classes\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UsersRepository;
use App\Http\Requests\UserRegiserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersRepository $users)
    {
        // $this->middleware('guest:api');
        $this->users = $users;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegiserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->users->create(
                $request->only(
                    ['name', 'email', 'username', 'password']
                )
            );
            DB::commit();

            return Response::success('User registered successfully', [
                'user' => $user,
                'token' => $user->createToken('Clients Token')->accessToken
            ]);
        } catch(Exception $e) {
            DB::rollBack();

            return Response::error($e->getMessage());
        }
    }
}
