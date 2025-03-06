<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class TestController extends Controller
{
    public function sendTestEmail()
    {
        $recipient = 'azizyana02@gmail.com';
        Mail::to($recipient)->send(new TestEmail());

        return 'Test email sent successfully!';
    }
}
