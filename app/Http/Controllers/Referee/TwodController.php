<?php

namespace App\Http\Controllers\Referee;
use Carbon\Carbon;

use App\Models\Agent;
use App\Models\Referee;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TwodController extends Controller
{
    // public function twoDSaleList(){
    //     $twoDSaleList = Twodsalelist::select('twodsalelists.id','twodsalelists.twod_id','twodsalelists.sale_amount',
    //     'twodsalelists.customer_name','users.name','twods.number')
    //     ->where('twodsalelists.status',1)
    //     ->orderBy('twodsalelists.id','desc')
    //     ->join('agents','agents.id','twodsalelists.agent_id')
    //     ->join('users','users.id','agents.user_id')
    //     ->join('twods','twods.id','twodsalelists.twod_id')
    //     ->get();
    //     //dd($twoDSaleList->toArray());
    //     return view('RefereeManagement.twodsalelist')->with(['twoDSaleList'=>$twoDSaleList]);
    // }
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function twoDSaleList(){

        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();

        $morning ='Morning';
        $evening ='Evening';
        $time = Carbon::Now()->toTimeString();
        $tdy_date=Carbon::now()->toDateString();

        if($time > 12){
            $twoDSaleList = Twodsalelist::select('twodsalelists.id','twodsalelists.twod_id','twodsalelists.sale_amount',
            'twodsalelists.customer_name','users.name','twods.number')
            ->whereIn('twodsalelists.agent_id',$agents)
            ->where('twodsalelists.status',1)
            ->where('twods.round',$evening)
            ->where('twods.date',$tdy_date)
            ->orderBy('twodsalelists.id','desc')
            ->join('agents','agents.id','twodsalelists.agent_id')
            ->join('users','users.id','agents.user_id')
            ->join('twods','twods.id','twodsalelists.twod_id')
            ->get();
        return view('RefereeManagement.twodsalelist')->with(['twoDSaleList'=>$twoDSaleList]);
        }else{
            $twoDSaleList = Twodsalelist::select('twodsalelists.id','twodsalelists.twod_id','twodsalelists.sale_amount',
            'twodsalelists.customer_name','users.name','twods.number')
            ->whereIn('twodsalelists.agent_id',$agents)
            ->where('twodsalelists.status',1)
            ->where('twodsalelists.date',$tdy_date)
            ->where('twods.round',$morning)
            ->orderBy('twodsalelists.id','desc')
            ->join('agents','agents.id','twodsalelists.agent_id')
            ->join('users','users.id','agents.user_id')
            ->join('twods','twods.id','twodsalelists.twod_id')
            ->get();
        return view('RefereeManagement.twodsalelist')->with(['twoDSaleList'=>$twoDSaleList]);
        }
    }

    public function searchthwodagent(Request $request){
        $data = Twodsalelist::select('twodsalelists.id','twodsalelists.twod_id','twodsalelists.sale_amount',
        'twodsalelists.customer_name','users.name','twods.number')
        ->where('twodsalelists.status',1)
        ->where('users.name','like','%'.$request->searchagent.'%')
        ->join('agents','agents.id','twodsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->join('twods','twods.id','twodsalelists.twod_id')
        ->get();
        //dd($data->toArray());
        return view('RefereeManagement.twodsalelist')->with(['twoDSaleList'=>$data]);
    }

}
