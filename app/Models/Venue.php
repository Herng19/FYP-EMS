<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function slots() {
        return $this->hasMany(Slot::class, 'venue_id', 'venue_id');
    }
}
