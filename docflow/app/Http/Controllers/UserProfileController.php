<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        // Update user profile logic here
    }
}
