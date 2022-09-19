<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    //
    public function MatchesRegister(){
        return view('system_admin.phaseTwo.matches.matches');
    }
}
