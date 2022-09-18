<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Threed extends Model
{
    use HasFactory;

    public function referees()
    {
        return $this->hasMany(Referee::class);
    }
    
    public function threedsalelists()
    {
        return $this->hasMany(Threedsalelist::class);
    }
}
