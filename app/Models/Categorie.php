<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    public function event_sportif(){
        $this->belongsTo(EventSportif::class);
    }

    public function athletes(){
        return $this->hasMany(Athlete::class);
    }
}
