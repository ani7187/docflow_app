<?php

namespace App\Models\document;

use App\Models\file\File;
use App\Models\section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
