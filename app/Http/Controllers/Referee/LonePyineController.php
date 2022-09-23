<?php

namespace App\Http\Controllers\Referee;
use App\Models\Agent;

use App\Models\Referee;
use Illuminate\Http\Request;
use App\Models\Lonepyinesalelist;
use App\Http\Controllers\Controller;

class LonePyineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function lonepyineSaleList(){
        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();

        $lonepyineSaleList = Lonepyinesalelist::select('lonepyinesalelists.id','lonepyinesalelists.lonepyine_id','lonepyinesalelists.sale_amount',
        'lonepyinesalelists.customer_name','users.name','lonepyines.number')
        ->whereIn('lonepyinesalelists.agent_id',$agents)
        ->where('lonepyinesalelists.status',1)
        ->join('agents','agents.id','lonepyinesalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
        ->get();

        //dd($lonepyineSaleList->toArray());
        return view('RefereeManagement.lonepyinesalelist')->with(['lonepyineSaleList'=>$lonepyineSaleList]);
    }
    public function searchlonepyineagent(Request $request){
        $data =  Lonepyinesalelist::select('lonepyinesalelists.id','lonepyinesalelists.lonepyine_id','lonepyinesalelists.sale_amount',
        'lonepyinesalelists.customer_name','users.name','lonepyines.number')
        ->where('lonepyinesalelists.status',1)
        ->where('users.name','like','%'.$request->searchagent.'%')
        ->join('agents','agents.id','lonepyinesalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
        ->get();
        return view('RefereeManagement.lonepyinesalelist')->with(['lonepyineSaleList'=>$data]);
    }
}
