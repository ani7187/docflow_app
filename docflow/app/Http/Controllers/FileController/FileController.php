<?php

namespace App\Http\Controllers\FileController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class FileController extends Controller
{
    public function download(Media $media)
    {
        $file = storage_path('app\\documents\\' . $media->id . '\\' . $media->file_name);
        $fileName = $media->file_name;

        $encryptedContents = file_get_contents($file);
        $decryptedContents = Crypt::decrypt($encryptedContents);

        return Response::streamDownload(function () use ($decryptedContents) {
            echo $decryptedContents;
        }, $fileName);
    }

    public function downloadAll(Media $media)
    { //todo
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir);
        }

        $mediaId = $media->id;


        $zipPath = $tempDir . '/media_' . $mediaId . '.zip';
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($media->files as $file) {
                $filePath = storage_path('app/documents/' . $file->id . '/' . $file->file_name);
                $fileName = $file->file_name;
                $zip->addFile($filePath, $fileName);
            }
            $zip->close();
        } else {
            // Handle error opening the zip archive
            return response()->json(['error' => 'Failed to create zip archive'], 500);
        }

        // Generate a streamed response for downloading the zip file
        $response = new StreamedResponse(function () use ($zipPath) {
            readfile($zipPath);
        });
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename="media_' . $mediaId . '.zip"');

        // Clean up the temporary directory
        unlink($zipPath);
        rmdir($tempDir);

        return $response;
    }

}
