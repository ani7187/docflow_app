<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Providers\RouteServiceProvider;
use Dflydev\DotAccessData\Data;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use function Psy\debug;

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

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 5; // Maximum number of login attempts allowed
    protected $decayMinutes = 5; // Lockout period in minutes

    protected $throttleBy = 'ip';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->ip() . '|' . $request->userAgent());
    }

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

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('error.failed_auth')],
        ]);
    }
}
