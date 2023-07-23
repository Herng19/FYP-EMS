<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Traits\HasRoles;

class Student extends Model
{
    use HasFactory;
    use HasRoles;

    public $guard_name = 'student';
    public $timestamps = false;
}
