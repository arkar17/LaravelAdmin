<?php

namespace App\Models;

use App\Models\Match;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matches extends Model
{
    use HasFactory;
    public function tournament()
    {
        return $this->belongsTo(Tournament::class,'tournament_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class,'team_one_id','team_two_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
