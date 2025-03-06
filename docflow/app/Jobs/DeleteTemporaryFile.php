<?php

namespace App\Jobs;

use App\Models\TemporaryFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteTemporaryFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $temporaryFile;

    /**
     * Create a new job instance.
     *
     * @param  TemporaryFile  $temporaryFile
     * @return void
     */
    public function __construct(TemporaryFile $temporaryFile)
    {
        $this->temporaryFile = $temporaryFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get folder name from the temporary file
        $folderName = $this->temporaryFile->folder_name;

        // Delete file from the temporary folder
        Storage::disk('storage')->deleteDirectory($folderName);

        // Optionally, you can also delete the temporary file record from the database
        $this->temporaryFile->delete();
    }
}
