<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lonepyinesalelist extends Model
{
    use HasFactory;

    public function lonepyine()
    {
        return $this->belongsTo(Lonepyine::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
