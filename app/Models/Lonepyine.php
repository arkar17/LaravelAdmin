<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lonepyine extends Model
{
    use HasFactory;

    public function referees()
    {
        return $this->hasMany(Referee::class,'referee_id');
    }

    public function lonepyinesalelists()
    {
        return $this->hasMany(Lonepyinesalelist::class);
    }
}
