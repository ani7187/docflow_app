<?php

namespace App\Http\Controllers\DocumentController;

use App\Http\Controllers\Controller;
use App\Models\document\Document;
use App\Models\file\File;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Models\sectionAdditionalColumn\SectionAdditionalColumn;
use App\Models\TemproaryFile;
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
            $sectionAdditionalColumns = SectionAdditionalColumn::where('section_id', $sectionId)->first();
        }

        $documents = Document::where('section_id', $sectionId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('documents.index', compact('section', 'userPermissions', 'sectionAdditionalColumns', 'documents')); //, 'users', 'userGroups'
    }


    public function add(Request $request)
    {
        $sectionId = $request->query('section');
        $section = Section::find($sectionId);
        $sectionAdditionalColumns = SectionAdditionalColumn::where('section_id', $sectionId)->first();

        return view('documents.add', compact('section', 'sectionAdditionalColumns'));
    }

    public function upload(Request $request)
    {
        if ($request->file('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid() . '_' . now()->timestamp;
            $file->storeAs('documents/tmp/' . $folder, $fileName);

            TemproaryFile::create([
                'folder' => $folder,
                'filename' => $fileName
            ]);

            return $folder;
        }
        return '';
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            $sectionID = $request->input('section_id');
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
            $document->creation_date = date('Y-m-d H:i:s');

            if ($request->input("due_date")) {
                $document->due_date = $request->input("due_date"); //todo make nullable
            }
            $document->unique_id = Str::uuid();
            $document->document_signature_status = 0;
            $document->document_execution_status = 1; //2finish
            $document->save();

            $tmpFile = TemproaryFile::where('folder', $request->file)->first();
            if ($tmpFile) {
                $document->addMedia(storage_path('app/documents/tmp/' . $request->file . '/' . $tmpFile->filename))
                    ->toMediaCollection('files', 'documents');

                rmdir(storage_path('app/documents/tmp/' . $request->file));
                $tmpFile->delete();
            }
            DB::commit();
            return redirect()->route('documents.index', ['section' => $sectionID])->with('success', Lang::get('menu.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Document $document)
    {
        $media = $document->getMedia('files');


        return view('documents.show', compact('document', 'media'));
    }
}
