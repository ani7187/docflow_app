<?php
namespace App\Services\DocumentService;

use App\Models\document\Document;
use App\Models\file\File;

class DocumentService
{
    public function store(array $requestData)
    {
        dd($requestData);
        // Validate input if necessary


        if ($requestData['file']) {
            $file = $requestData['file'];
            $originalFilename = $file->getClientOriginalName(); //for storing in db
            $file->store('documents');
        }

        // Create document
//        $document = Document::create([
//            'title' => $requestData['title'], // Example
//            // Add other document attributes here
//        ]);
//
//        // Save files
//        $uploadedFiles = [];
//        foreach ($requestData['files'] as $uploadedFile) {
//            $fileModel = new File();
//            $fileModel->filename = $uploadedFile->getClientOriginalName(); // Or any other desired field
//            // Populate other file attributes as needed
//            $fileModel->document_id = $document->id; // Associate with the document
//            $fileModel->save();
//
//            // Move the file to the desired location
//            $uploadedFile->storeAs('uploads', $fileModel->filename);
//
//            $uploadedFiles[] = $fileModel;
//        }

        return $document;
    }
}
