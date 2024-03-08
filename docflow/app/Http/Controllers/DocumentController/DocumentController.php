<?php

namespace App\Http\Controllers\DocumentController;

use App\Http\Controllers\Controller;
use App\Models\document\Document;
use App\Models\file\File;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Models\sectionAdditionalColumn\SectionAdditionalColumn;
use App\Models\User;
use App\Services\DocumentService\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $sectionId = $request->query('section');
        $section = Section::find($sectionId);
        $userGroups = $user->userGroups;

        $lastPermission = Permission::where('section_id', $sectionId)
            ->where(function ($query) use ($user, $userGroups) {
                $query->where('user_id', $user->id)
                    ->orWhereIn('user_group_id', $userGroups->pluck('id'));
            })
            ->latest('created_at') // Order by creation date in descending order
            ->first();

        $userPermissions = [];
        $sectionAdditionalColumns = [];
        if ($lastPermission) {
            $userPermissions = $lastPermission->toArray();
//            $permissionId = $lastPermission->id;
//            $sectionId = $lastPermission->section_id;

            $sectionAdditionalColumns = SectionAdditionalColumn::where('section_id', $sectionId)->first();
        }

        $documents = Document::where('section_id', $sectionId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('documents.index', compact('section', 'userPermissions', 'sectionAdditionalColumns', 'documents')); //, 'users', 'userGroups'
    }


    public function add(Request $request){
        $sectionId = $request->query('section');
        $section = Section::find($sectionId);
        $sectionAdditionalColumns = SectionAdditionalColumn::where('section_id', $sectionId)->first();

        return view('documents.add', compact('section', 'sectionAdditionalColumns'));
    }


    public function store(Request $request)
    {
//        dd($request);
//        $request->validate([
//            'section_id' => 'required|numeric',
//        ]);
        dd($request);
        try {
            DB::beginTransaction();
            $sectionID = $request->input('section_id');
            if ($request->hasFile('file')) {
                $uniqueID = Str::uuid();

                $file = $request->file('file');
                $fileName = $uniqueID.$file->getClientOriginalExtension();
                $file->storeAs('documents', $fileName);


                $document = new Document();
                $document->section_id = $sectionID;
                if ($request->input("number")) {
                    $document->number = $request->input("number");
                }
                if ($request->input("name")) {
                    $document->name = $request->input("name");
                }
                if ($request->input("notes")) {
                    $document->notes = $request->input("notes");
                }
                $document->uploaded_by = auth()->user()->id;
                $document->creation_date = Carbon::now();

                if ($request->input("due_date")) {
                    $document->due_date = Carbon::now(); //todo make nullable
                }
                $document->unique_id = Str::uuid();
                $document->document_signature_status = 0;
                $document->document_execution_status = 1; //2finish
                $document->save();



                $fileModel = new File();
                $fileModel->section_id = $sectionID;
                $fileModel->document_id = $document->id;
                $fileModel->unique_id = $uniqueID;
                $fileModel->uploaded_by = auth()->user()->id;
                $fileModel->uploaded_at = Carbon::now();
                $fileModel->file_size = $file->getSize();
                $fileModel->file_content_type = $file->getClientMimeType();

    //            $fileModel->
                $fileModel->name = $file->getClientOriginalName(); // Or any other desired field
                // Populate other fields as needed
                $fileModel->save();
            }
            DB::commit();
            return redirect()->route('documents.index', ['section' => $sectionID])->with('success', Lang::get('menu.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

//        return response()->json(["success" => $request->hasFile('file')]);

        // Return a response

    }
}
