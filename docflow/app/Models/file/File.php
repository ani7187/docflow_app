<?php

namespace App\Models\file;

use App\Models\document\Document;
use App\Models\section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
