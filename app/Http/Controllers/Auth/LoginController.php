<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username()
    {
        return !filter_var(request()->username, FILTER_VALIDATE_EMAIL) ? 'username' : 'email';
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 
            'password' => 'required',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            [ 
                $this->username() =>  $request->username,
                'password' => $request->password,
                'is_active' => true,
                'confirmed' => true,
            ], 
            $request->has('remember')
        );
    }
}
