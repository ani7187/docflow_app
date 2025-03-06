<?php

namespace App\Traits;

use App\Models\actionHistory\ActionHistory;
use App\Models\file\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait DocumentFilesTrait
{
    /**
     * @param int $documentID
     * @return array
     */
    public function getDocFiles(int $documentID): array
    {
        $media = [];
        $files = File::where('document_id', $documentID)->get();
        foreach ($files as $file) {
            $fileExtension = pathinfo($file->name, PATHINFO_EXTENSION);
            $media[] = array(
                'url' => Storage::disk('minio')->url("documents/public/{$file->unique_id}/{$file->name}"),
                'name' => $file->name,
                'extension' => $fileExtension,
                'size' => $file->file_size,
                'type' => $file->file_content_type,
                'unique_id' => $file->unique_id
            );
        }

        return $media;
    }
}
