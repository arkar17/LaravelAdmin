<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operationstaff extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referees()
    {
        return $this->hasMany(Referee::class);
    }

    // public static function boot() {
    //     parent::boot();
    //     self::deleting(function($operationstaff) {
    //         $operationstaff->referees()->each(function($referee) {
    //             $referee->delete();
    //         });
    //     });
    // }
}

