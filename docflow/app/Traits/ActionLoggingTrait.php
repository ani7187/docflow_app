<?php

namespace App\Traits;

use App\Models\actionHistory\ActionHistory;
use Illuminate\Support\Facades\Log;
trait ActionLoggingTrait
{
    /**
     * @param string $actionName
     * @param string $notes
     * @param int $receiverID
     * @param int $documentID
     * @return void
     */
    public function logAction(string $actionName = "undefined", string $notes = "", int $receiverID = 0, int $documentID = 0): void
    {
        $actionHistory = new ActionHistory();
        $actionHistory->executor_id = auth()->user()->id;
        if (!empty($receiverID)) {
            $actionHistory->receiver_id = $receiverID;
        }
        $actionHistory->action_name = $actionName;
        $actionHistory->notes = $notes;
        $actionHistory->document_id = $documentID;
        $actionHistory->save();
    }
}
