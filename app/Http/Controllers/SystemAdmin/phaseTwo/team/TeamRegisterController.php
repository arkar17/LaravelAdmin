<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo\team;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamRegisterController extends Controller
{
    public function teamRegister(){
        return view('system_admin.phaseTwo.team.team_register');
    }
    public function teamCreate(Request $request){
        $user = auth()->user()->id;
        $team = new Team();
        $team->name = $request->teamname;
        $team->user_id =$user;
        $team->save();
        return back();
    }
}
