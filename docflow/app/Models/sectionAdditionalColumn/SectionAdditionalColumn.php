<?php

namespace App\Models\sectionAdditionalColumn;

use App\Models\section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionAdditionalColumn extends Model
{
    use HasFactory;
    protected $fillable = ['section_id', 'number', 'name', 'notes', 'uploaded_by', 'created_by', 'signed_by', 'creation_date', 'due_date'];

    public const NUMBER = 'number';
    public const NAME = 'name';
    public const NOTES = 'notes';
    public const UPLOADED_BY = 'uploaded_by';
    public const CREATED_BY = 'created_by';
    public const SIGNED_BY = 'signed_by';
    public const CREATION_DATE = 'creation_date';
    public const DUE_DATE = 'due_date';



    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
