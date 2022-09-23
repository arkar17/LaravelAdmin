<?php

namespace App\Http\Controllers\Referee;
use App\Models\Agent;

use App\Models\Referee;
use Illuminate\Http\Request;
use App\Models\Threedsalelist;
use App\Models\Threed_Sales_list;
use App\Http\Controllers\Controller;

class ThreedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function threeDSaleList(){
        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();

        $threeDSaleList = Threedsalelist::select('threedsalelists.id','threedsalelists.threed_id','threedsalelists.sale_amount',
        'threedsalelists.customer_name','users.name','threeds.number')
        ->whereIn('threedsalelists.agent_id',$agents)
        ->where('threedsalelists.status',1)
        ->orderBy('threedsalelists.id','desc')
        ->join('threeds','threeds.id','threedsalelists.threed_id')
        ->join('agents','agents.id','threedsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->get();
        //dd($threeDSaleList->toArray());
        return view('RefereeManagement.threedsalelist')->with(['threeDSaleList'=>$threeDSaleList]);
    }

    public function searchthreeddagent(Request $request){
        $data = Threedsalelist::select('threedsalelists.id','threedsalelists.threed_id','threedsalelists.sale_amount',
        'threedsalelists.customer_name','users.name','threeds.number')
        ->where('threedsalelists.status',1)
        ->where('users.name','like','%'.$request->searchagent.'%')
        ->join('threeds','threeds.id','threedsalelists.threed_id')
        ->join('agents','agents.id','threedsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->get();

        return view('RefereeManagement.threedsalelist')->with(['threeDSaleList'=>$data]);
    }
}
