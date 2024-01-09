<?php

namespace App\Models;

use App\Models\SubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoLevel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $primaryKey = 'co_level_id';

    protected $fillable = [
        'co_level_name',
        'co_level_description',
    ];

    public function sub_criterias() {
        return $this->hasMany(SubCriteria::class, 'co_level_id', 'co_level_id');
    }
}
