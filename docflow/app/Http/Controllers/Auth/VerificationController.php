<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

//    public function verify(Request $request)
//    {
//        // Check if URL is a valid verification link
//        echo "here";
//
//        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
//            echo "here";
//            throw new AuthorizationException;
//        }
//
//        // Check if user is already verified
//        if ($request->user()->hasVerifiedEmail()) {
//            return redirect($this->redirectPath())->with('success', 'Email already verified.');
//        }
//
//        // Verify the user's email
//        if ($request->user()->markEmailAsVerified()) {
//            event(new Verified($request->user()));
//        }
//
//        // Perform custom logic upon verification
//        // This could include database updates, notifications, etc.
//
//        return redirect($this->redirectPath())->with('success', 'Email verified successfully.');
//    }
}
