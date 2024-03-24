<?php

namespace App\Http\Controllers\InboxController;

use App\Http\Controllers\Controller;
use App\Models\actionHistory\ActionHistory;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $history = ActionHistory::where('receiver_id', "=", auth()->user()->id)->paginate(10);//todo add execution status

        return view('inbox.index', compact('history'));
    }
}
