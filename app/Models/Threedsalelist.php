<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Threedsalelist extends Model
{
    use HasFactory;

    public function threed()
    {
        return $this->belongsTo(Threed::class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
