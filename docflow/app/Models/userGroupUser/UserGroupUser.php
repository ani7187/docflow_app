<?php

namespace App\Models\userGroupUser;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroupUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_group_user';
    protected $primaryKey = ['user_id', 'user_group_id'];
    public $timestamps = false;
    protected $fillable = [
        'user_group_id',
        'user_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
