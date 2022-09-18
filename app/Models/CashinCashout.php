<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashinCashout extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id','id');
    }

    public function referee()
    {
        return $this->belongsTo(Referee::class,'referee_id','id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
