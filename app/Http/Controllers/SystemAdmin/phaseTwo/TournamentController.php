<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    //
    public function tournamentRegister(){
        return view('system_admin.phaseTwo.tournament.tournament_register');
    }
}
