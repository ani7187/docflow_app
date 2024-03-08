<?php

namespace App\Http\Controllers\FileController;

use App\Http\Controllers\Controller;
use App\Models\file\File;
use App\Models\section\Section;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request, Section $section)
    {

        dd($request->hasFile('file'));
//        $request->validate([
//            'files.*' => 'required|file|mimes:jpg,png,pdf|max:2048', // Example validation rules for files
//            // Add validation rules for other form fields here
//        ]);

        // Save data associated with the files in the database
        $files = [];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName(); //for storing in db
            $file->store('documents');

            $fileModel = new File();
            $fileModel->section_id = $section->id;
            $fileModel->document_id = 1;
            $fileModel->unique_id = "4545";
//            $fileModel->
            $fileModel->name = $file->getClientOriginalName(); // Or any other desired field
            // Populate other fields as needed
            $fileModel->save();
        }
//        foreach ($request->file('file') as $uploadedFile) {
//
//
//            // Move the file to the desired location
//            $uploadedFile->storeAs('uploads', $fileModel->name);
//
//            $files[] = $fileModel;
//        }

//        return back()->with('success', 'Files uploaded and data saved successfully.');
//        return response()->json(["success" => $request->hasFile('file')]);

    }

}
