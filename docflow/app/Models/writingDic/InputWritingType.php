<?php

namespace App\Models\writingDic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputWritingType extends Model
{
    use HasFactory;

    protected $table = "input_writing_types";
    protected $guarded = false;
}
