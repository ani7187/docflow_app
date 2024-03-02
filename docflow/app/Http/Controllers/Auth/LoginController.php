<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dflydev\DotAccessData\Data;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
//    public function login(Request $request)
//    {
//        $this->validateLogin($request);
//
//        // If the login attempt should be prevented due to email verification
//        if (!$this->canLogin($request)) {
//            return $this->sendFailedLoginResponse($request);
//        }
//
//        // Attempt to log in the user
//        if ($this->attemptLogin($request)) {
//            return $this->sendLoginResponse($request);
//        }
//
//        // If the login attempt was not successful, handle the failed login response
//        return $this->sendFailedLoginResponse($request);
//    }

    /**
     * Determine if the user can be logged in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
//    protected function canLogin(Request $request)
//    {
//        // Retrieve the user attempting to log in
//        $user = $this->guard()->getProvider()->retrieveByCredentials($this->credentials($request));
//
//        // Check if the user exists and their email is verified
//        return $user && $user->hasVerifiedEmail();
//    }

    /**
     * Send the response after the user failed authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
//    protected function sendFailedLoginResponse(Request $request)
//    {
//        $errors = [$this->username() => trans('auth.failed')];
//
//        // Check if the login attempt was due to unverified email
//        if (!$this->canLogin($request)) {
//            $errors = [$this->username() => trans('auth.email_not_verified')];
//        }
//
//        throw ValidationException::withMessages($errors);
//    }



    /**
     * @param Request $request
     * @return void
     */
    protected function validateLogin(Request $request): void
    {
        $messages = [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'email.exists' => Lang::get("error.invalid_email"),
            'failed' => 'ee'
        ];

        $email = $request->input("email");
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('users')->where('email', $email),
            ],
            'password' => ['required', 'string'],
        ], $messages);
    }

//    protected function sendFailedLoginResponse(Request $request)
//    {
//        throw ValidationException::withMessages([
//            $this->username() => [trans('error.failed_auth')],
//        ]);
//    }
}
