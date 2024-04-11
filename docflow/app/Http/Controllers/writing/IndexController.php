<?php

namespace App\Http\Controllers\writing;

use App\Http\Controllers\Controller;
use App\Models\actionHistory\ActionHistory;
use App\Models\document\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        if (auth()->check()) {
            // User is logged in
//            dd('here');

            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();

            $signedCount = ActionHistory::where('action_name', 'sign')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $currentCount = Document::where('document_execution_status', 1)->count();
            $finishCount = Document::where('document_execution_status', 2)->count();

            return view("writing.index", compact('signedCount', 'startDate', 'currentCount', 'finishCount'));
        } else {
            // User is not logged in
            return view("auth.login");
        }
    }
}
