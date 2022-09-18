<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referee()
    {
        return $this->belongsTo(Referee::class);
    }


    public function cashincashout()
    {
        return $this->hasOne(CashinCashout::class,'agent_id','id');
    }


}
