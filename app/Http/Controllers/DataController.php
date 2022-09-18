<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function refereedata()
    {
        $referees = Agent::whereNotNull('referee_id')->get();
        return view('data.refereedata',compact('referees'));
    }

    public function agentdata()
    {
        return view('data.agentdata');
    }

}
