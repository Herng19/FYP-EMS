<?php

namespace App\Models;

use App\Models\IndustrialSubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialCoLevel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $primaryKey = 'industrial_co_level_id';

    protected $fillable = [
        'co_level_name',
        'co_level_description',
    ];

    public function industrial_sub_criterias() {
        return $this->hasMany(IndustrialSubCriteria::class, 'industrial_co_level_id', 'industrial_co_level_id');
    }
}
