<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referee extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'referee_code',
        'user_id',
        'operation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operationstaff()
    {
        return $this->belongsTo(Operationstaff::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function twods()
    {
        return $this->hasMany(Twod::class);
    }

    public function threeds()
    {
        return $this->hasMany(Twod::class);
    }

    public function lonepyine()
    {
        return $this->hasMany(Lonepyine::class);
    }

    public function cashincashout()
    {
        return $this->hasOne(CashinCashout::class);
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($referee) {
            $referee->agents()->each(function($agent) {
                $agent->delete();
            });
        });

        // self::updating(function ($referee) {
        //     if ($referee->avaliable_date < Carbon::now()) {
        //         $referee->active_status = 0;
        //     }
        // });

    }
}
