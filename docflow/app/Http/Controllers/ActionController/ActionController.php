<?php

namespace App\Http\Controllers\ActionController;

use App\Http\Controllers\Controller;
use App\Models\document\Document;
use App\Models\file\File;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Models\sectionAdditionalColumn\SectionAdditionalColumn;
use App\Models\sendToConfirmation\SendToConfirmation;
use App\Models\TemproaryFile;
use App\Models\User;
use App\Services\DocumentService\DocumentService;
use App\Traits\ActionLoggingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActionController extends Controller
{
    use ActionLoggingTrait;

    public function send_to_confirmation(Request $request, Document $document)
    {
        $section = $request->input('section_id');
        $users = $this->getUserData();
//        dd($users);
        return view('documents.actions.send_to_confirmation', compact('document', 'section', 'users'));
    }

    public function send(Request $request, Document $document)
    {
        try {
            DB::beginTransaction();
            $sectionID = $request->input('section_id');
            $notes = $request->input('notes') ?? "";
            $receiverIDList = $request->input("receiver_ids");

            foreach ($receiverIDList as $receiverID) {
                $sendToConfirmation = new SendToConfirmation();
                $sendToConfirmation->document_id = $document->id;
                $sendToConfirmation->executor_id = auth()->user()->id;
                $sendToConfirmation->receiver_id = $receiverID;
                $sendToConfirmation->save();

                $this->logAction("send_to_confirmation", $notes, $receiverID, $document->id);
            }
            DB::commit();
            return redirect()->route('documents.show', ['document' => $document->id, 'section' => $sectionID]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function confirm_show(Request $request, Document $document)
    {
        $section = $request->input('section_id');
        $media = $document->getMedia('files');
        return view('documents.actions.confirm_show', compact('document', 'section', 'media'));
    }

    public function send_to_sign(Request $request, Document $document)
    {
        $section = $request->input('section_id');
        $users = $this->getUserData();
//        dd($users);
        return view('documents.actions.send_to_confirmation', compact('document', 'section', 'users'));
    }

    public function sign_show(Request $request, Document $document)
    {
        $section = $request->input('section_id');
        $media = $document->getMedia('files');
        return view('documents.actions.sign_show', compact('document', 'section', 'media'));
    }


    /**
     * @return array
     */
    private function getUserData(): array
    {
        $user = Auth::user();
        if ($user->partnerOrganization) {
            $id = $user->partnerOrganization->id;
        } elseif ($user->partnerPerson) {
            $id = $user->partnerPerson->partner_organization_id;
        }

        $partnerOrganization = PartnerOrganization::findOrFail($id);
        $partnerPersons = $partnerOrganization->partnerPersons;
        $users = [];
        foreach ($partnerPersons as $key => $partnerPerson) {
            $users[] = User::findOrFail($partnerPerson->user_id);
        }

        return $users;
    }
}
