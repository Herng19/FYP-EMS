<?php

namespace App\Models;

use App\Models\Evaluation;
use App\Models\SubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CriteriaMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_criteria_id',
        'evaluation_id',
        'scale',
    ];

    protected $primaryKey = 'criteria_mark_id';

    public $timestamps = false;

    public function evaluation() {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'evaluation_id');
    }

    public function sub_criteria() {
        return $this->belongsTo(SubCriteria::class, 'sub_criteria_id', 'sub_criteria_id');
    }
}
