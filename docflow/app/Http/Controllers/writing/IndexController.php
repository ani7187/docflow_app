<?php

namespace App\Http\Controllers\writing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        if (auth()->check()) {
            // User is logged in
            return view("writing.index");
        } else {
            // User is not logged in
            return view("auth.login");
        }
    }
}
