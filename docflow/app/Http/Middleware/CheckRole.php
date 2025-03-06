<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
//        dd((int)$request->user()->role_id);
//        dd(UserRole::EMPLOYEE);
        // Check if user has any of the specified roles
        if (!$request->user() || (int)$request->user()->role_id->value != $role) {
            // Redirect or abort depending on your requirements
            abort(403, 'Access Denied');
        }

        return $next($request);
    }
}
