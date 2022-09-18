<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twod extends Model
{
    use HasFactory;

    public function referees()
    {
        return $this->hasMany(Referee::class);
    }

    public function twodsalelists()
    {
        return $this->hasMany(Twodsalelist::class);
    }
}
