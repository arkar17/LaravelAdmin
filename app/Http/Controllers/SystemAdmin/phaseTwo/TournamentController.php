<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    //
    public function tournamentRegister(){
        return view('system_admin.phaseTwo.tournament.tournament_register');
    }
    public function tournamentStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        $user = auth()->user()->id;
        $tournament_register = new Tournament();
        $tournament_register->name = $request->name;
        $tournament_register->user_id = $user;
        $tournament_register->save();
        return redirect()->back()->with('success', 'New tournament is created successfully!');
    }
}
