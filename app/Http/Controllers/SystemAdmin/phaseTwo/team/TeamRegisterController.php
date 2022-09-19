<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo\team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamRegisterController extends Controller
{
    public function teamRegister(){
        return view('system_admin.phaseTwo.team.team_register');
    }
}
