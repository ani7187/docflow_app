<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const COMPANY = 2;
    const EMPLOYEE = 3;

}
