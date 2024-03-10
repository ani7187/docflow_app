<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\partnerPerson\PartnerPerson;
use App\Models\section\Section;
use App\Models\userGroup\UserGroup;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'delete_status',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role_id' => UserRole::class,
    ];

//    protected $dates = ['deleted_at'];

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserRole::class);
    }

    public function partnerPerson(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PartnerPerson::class);
    }

    public function partnerOrganization(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PartnerOrganization::class);
    }

    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class, 'user_group_user', 'user_id', 'user_group_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
