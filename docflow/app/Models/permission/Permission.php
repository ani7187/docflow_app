<?php

namespace App\Models\permission;

use App\Models\section\Section;
use App\Models\User;
use App\Models\userGroup\UserGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['can_preview', 'can_view', 'can_edit', 'can_add', 'user_id', 'user_group_id', 'expires_at'];

    public const PERMISSION_PREVIEW = 'can_preview';
    public const PERMISSION_VIEW = 'can_view';
    public const PERMISSION_EDIT = 'can_edit';
    public const PERMISSION_ADD = 'can_add';


    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class);
    }
}
