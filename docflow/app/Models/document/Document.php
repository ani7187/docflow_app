<?php

namespace App\Models\document;

use App\Models\file\File;
use App\Models\section\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
