<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function cashincashout()
    {
        return $this->belongsTo(CashinCashout::class);
    }

    public function twodsalelist()
    {
        return $this->belongsTo(Twodsalelist::class);
    }

    public function threedsalelist()
    {
        return $this->belongsTo(Threedsalelist::class);
    }
}
