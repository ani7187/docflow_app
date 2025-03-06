<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        dd("a");
        if ($request->user() && !$request->user()->hasVerifiedEmail() && $request->route()->getName() !== 'verification.notice') {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : redirect()->route('verification.notice');
        }else if (Auth::check() && Auth::user()->hasVerifiedEmail() && $request->route()->getName() == 'verification.notice') {
            return redirect()->route('writing.index'); // Redirect to the home page if email is verified
        }

        return $next($request);
    }
}
