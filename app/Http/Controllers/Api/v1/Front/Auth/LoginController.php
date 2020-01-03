<?php

namespace App\Http\Controllers\Api\v1\Front\Auth;

use App\Models\User;
use App\Classes\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Middleware\ThrottleRequests;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('throttle:10');
    }

    public function login(Request $request)
    {
        if (Auth::guard('api')->check()) {
            // return; // Needs refactoring
        }

        $this->validateLogin($request);

        if (!empty($user = $this->getUser($request))) {
            return Response::success('Login successful', [
                'user' => $user,
                'remember' => $request->has('remember') ? 30 : 1/24,
                'token' => $user->createToken('General Token')->accessToken
            ]);
        }

        return Response::error('Invalid username or password', 401);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        // $this->incrementLoginAttempts($request);

        // return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function getUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (!empty($user = Auth::guard('api')->user())) {
            $user->revokeTokens();
        }
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
