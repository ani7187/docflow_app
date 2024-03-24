<?php

namespace App\Http\Controllers\DocumentController;

use App\Http\Controllers\Controller;
use App\Models\document\Document;
use App\Models\file\File;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Models\sectionAdditionalColumn\SectionAdditionalColumn;
use App\Models\TemproaryFile;
use App\Models\User;
use App\Services\DocumentService\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    /*public function upload(Request $request)
    {
//        $request->validate([
//            'file' => 'required|file|mimes:jpeg,jpg,png,pdf,zip,docx,doc,xls,xlsx|max:50000'
//        ]);

        if ($request->file('file')) {
            $folder = uniqid() . '_' . now()->timestamp;
            foreach ($request->file('file') as $file) {
//                $file = $fileData;

                $fileName = $file->getClientOriginalName();
                $file = Crypt::encrypt(file_get_contents($file));
//                $file->storeAs('documents/tmp/' . $folder, $fileName);
                Storage::put("documents/tmp/$folder/$fileName", $file);

                TemproaryFile::create([
                    'folder' => $folder,
                    'filename' => $fileName
                ]);
            }

            return $folder;
        }
        return '';
    }*/

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $folder = uniqid() . '_' . now()->timestamp;
            foreach ($request->file('file') as $file) {
                $fileName = $file->getClientOriginalName();
                $fileContents = file_get_contents($file);
                Storage::disk('minio')->put("documents/tmp/$folder/$fileName", $fileContents);
                TemproaryFile::create([
                    'folder' => $folder,
                    'filename' => $fileName
                ]);
            }
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


            /*if (!empty($request->file)) {//save via media
                foreach ($request->file as $file) {

                    $tmpFile = TemproaryFile::where('folder', $file)->first();
//                    dd($request->file, $tmpFile);
                    if ($tmpFile) {
//                        dd($tmpFile);

//                        $path = Storage::disk('minio')->put('doc/', $tmpFile);
////                        $path = Storage::disk('minio')->putFileAs(
////                            'doc/', $tmpFile, $tmpFile->fileName
////                        );
//                        $url = Storage::disk('minio')->temporaryUrl($path, Carbon::now()->addMinutes(2));
//                        echo$url;
//                        die();
//                        dd($path);
//                        dd(1,$tmpFile);

                        $document->addMedia(storage_path('app/documents/tmp/' . $file . '/' . $tmpFile->filename))
                            ->toMediaCollection('files', 'documents');

//                        dd($tmpFile);
                        $tmpFile->delete();
                        rmdir(storage_path('app/documents/tmp/' . $file));
                    }
                }
            }*/

            if (!empty($request->file)) {
                foreach ($request->file as $folder) {

                    $filePath = Storage::disk('minio')->files("documents/tmp/$folder")[0];
                    $fileName = basename($filePath);
                    $fileSize = Storage::disk('minio')->size($filePath);
                    $fileContentType = Storage::disk('minio')->mimeType($filePath);
                    $uuid = Str::uuid();
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                    Storage::disk('minio')->move($filePath, "documents/public/{$uuid}.{$fileExtension}");

                    $file = new File();
                    $file->section_id = $sectionID;
                    $file->document_id = $document->id;
                    $file->name = $fileName;
                    $file->unique_id = $uuid;
                    $file->uploaded_by = auth()->user()->id;
                    $file->uploaded_at = date('Y-m-d H:i:s');
                    $file->file_size = $fileSize;
                    $file->file_content_type = $fileContentType;
                    $file->save();

                    Storage::disk('minio')->deleteDirectory($filePath);
                }
            }

            $this->logAction("create_document", "", "", $document->id);
            DB::commit();
            return redirect()->route('documents.show', ['document' => $document->id, 'section' => $sectionID])->with('success', Lang::get('menu.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /*public function show(Document $document)
    {
        $media = $document->getMedia('files');
        $history = $document->actionHistory()->orderBy('created_at', 'desc')->get();
        $receiveAction = $document->actionHistory()->where("receiver_id", auth()->user()->id)->pluck('action_name');
//        dd($receiveAction);
        return view('documents.show', compact('document', 'media', 'history'));
    }*/
    public function show(Document $document)
    {
        try {
            $history = $document->actionHistory()->orderBy('created_at', 'desc')->get();
            $media = [];
            $files = File::where('document_id', $document->id)->get();
            foreach ($files as $file) {
                $fileExtension = pathinfo($file->name, PATHINFO_EXTENSION);
                $media[] = array(
                    'url' => Storage::disk('minio')->url("documents/public/{$file->unique_id}.{$fileExtension}"),
                    'name' => $file->name,
                    'extension' => $fileExtension,
                );
            }

            return view('documents.show', compact('document', 'media', 'history'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function history(Document $document)
    {
        $history = $document->actionHistory;
//        dd($history);
        return response()->json($history);
    }

    public function edit(Request $request, Document $document)
    {
        $sectionId = $request->query('section');
        $section = Section::find($sectionId);
        $sectionAdditionalColumns = SectionAdditionalColumn::where('section_id', $sectionId)->first();
        $media = $document->getMedia('files');
        return view('documents.edit', compact('document', 'media', 'section', 'sectionAdditionalColumns'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'section_id' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            $sectionID = $request->input('section_id');
            $updateAssoc = [];

            if ($request->input("number")) {
                $updateAssoc['number'] = $request->input("number");
            }
            if ($request->input("name")) {
                $updateAssoc['name'] = $request->input("name");
            }
            if ($request->input("notes")) {
                $updateAssoc['notes'] = $request->input("notes");
            }

            if ($request->input("due_date")) {
                $updateAssoc['due_date'] = $request->input("due_date"); //todo make nullable
            }

            $document->update($updateAssoc);
//dd($request->file);
            if (!empty($request->file)) {
                $media = $document->getMedia('files');
//                dd($media);
                foreach ($media as $file) {
//                    dd($file->id);
                    $document->deleteMedia($file->id);
                }
                foreach ($request->file as $file) {

                    $tmpFile = TemproaryFile::where('folder', $file)->first();

//                    dd($request->file, $tmpFile);
                    if ($tmpFile) {
//                        dd($tmpFile);

//                        $path = Storage::disk('minio')->put('doc/', $tmpFile);
////                        $path = Storage::disk('minio')->putFileAs(
////                            'doc/', $tmpFile, $tmpFile->fileName
////                        );
//                        $url = Storage::disk('minio')->temporaryUrl($path, Carbon::now()->addMinutes(2));
//                        echo$url;
//                        die();
//                        dd($path);
                        $document->addMedia(storage_path('app/documents/tmp/' . $file . '/' . $tmpFile->filename))
                            ->toMediaCollection('files', 'documents');

                        $tmpFile->delete();
                        rmdir(storage_path('app/documents/tmp/' . $file));
                    }
                }
            }

            DB::commit();

            return redirect()->route('documents.show', ['document' => $document->id, 'section' => $sectionID])->with('success', Lang::get('menu.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Document $document)
    {
        // Delete the permission
        $document->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', Lang::get('menu.success_delete'));
    }
}
