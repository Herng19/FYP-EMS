<?php

namespace App\Models;

use App\Models\Evaluation;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    
    public $guard_name = 'student';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function research_group() {
        return $this->belongsTo(ResearchGroup::class, 'research_group_id', 'research_group_id');
    }

    public function slot() {
        return $this->hasOne(Slot::class, 'student_id', 'student_id');
    }

    public function project() {
        return $this->hasOne(Project::class, 'student_id', 'student_id');
    }

    public function evaluators() {
        return $this->belongsToMany(Lecturer::class, 'evaluator_lists', 'student_id', 'lecturer_id');
    }

    public function supervisors() {
        return $this->belongsToMany(Lecturer::class, 'supervisor_lists', 'student_id', 'lecturer_id');
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'student_id', 'student_id');
    }
}
