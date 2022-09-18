<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twodsalelist extends Model
{
    use HasFactory;

    public function twod()
    {
        return $this->belongsTo(Twod::class);
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
