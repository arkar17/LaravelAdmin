<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo;

use App\Models\Team;
use App\Models\Matches;
use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchesController extends Controller
{
    //
    public function MatchesRegister(){
        $match_register_tournaments=Tournament::all();
        $match_register_teams=Team::all();
        return view('system_admin.phaseTwo.matches.matches',compact('match_register_tournaments','match_register_teams'));
    }

    public function store(Request $request){

        $matches = new Matches();
        $matches->user_id=auth()->user()->id;
        $matches->team_one_id=$request->team_one_name;
        $matches->team_two_id=$request->team_two_name;
        $matches->tournament_id=$request->tournament_name;
        $matches->date = $request->date;
        $matches->time = $request->time;
        $matches->match_type=$request->match_type;
        $matches->save();
        return redirect()->back()->with('success', 'New Match is Created Successfully!');
    }
}
