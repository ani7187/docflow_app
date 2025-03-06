<?php

namespace App\Http\Controllers\InboxController;

use App\Http\Controllers\Controller;
use App\Models\actionHistory\ActionHistory;
use App\Models\document\Document;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        /*if (!empty($search)) {
            $history = ActionHistory::query()
                ->where(function ($query) use ($search) {
                    $query->whereRaw('true'); // Ensures "AND" logic for the following conditions
                    foreach (ActionHistory::$searchable as $column) {
                        $query->orWhere($column, 'like', "%{$search}%");
                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {*/
        $signHistory = ActionHistory::where('receiver_id', "=", auth()->user()->id)
            ->where('finish_status', "=", 0)
            ->where('action_name', '=', 'send_to_sign')
            ->orderBy('created_at', 'desc')
            ->paginate(10);//todo add execution status

        $confirmationHistory = ActionHistory::where('receiver_id', "=", auth()->user()->id)
            ->where('finish_status', "=", 0)
            ->where('action_name', '=', 'send_to_confirmation')
            ->orderBy('created_at', 'desc')
            ->paginate(10);//todo add execution status

//        }
        foreach ($signHistory as &$action) {
            $action['section_id'] = Document::where('id', $action->documet_id)->value('section_id');
        }

        foreach ($confirmationHistory as &$action) {
            $action['section_id'] = Document::where('id', $action->documet_id)->value('section_id');
        }

        return view('inbox.index', compact('signHistory', 'confirmationHistory'));
    }
}
