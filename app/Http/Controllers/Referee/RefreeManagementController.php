<?php

namespace App\Http\Controllers\Referee;

use auth;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Twod;
use App\Models\User;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Referee;
use App\Models\Requests;
use App\Models\Lonepyine;
use Illuminate\Support\Arr;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use App\Models\MaincashHitory;
use App\Models\Threedsalelist;
use App\Models\AgentcashHistory;
use App\Models\Lonepyinesalelist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RefreeManagementController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function refereeCoinAmt()
    {
        $user_id = auth()->user()->id;
        $coin = Referee::where('user_id',$user_id)->first();
        $coinamt = $coin->main_cash;
        return view('RefereeManagement.layout.app',compact('coinamt'));
    }
    public function agentData()
    {
        return view('RefereeManagement.agentdata');
    }
    public function agentList()
    {
        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $agentrequests = User::select('users.id','users.name','users.phone')
                        ->where('status', '=', 1)
                        ->where('request_type', '=', 'Agent')
                        ->Join('referees','referees.referee_code','users.referee_code')
                        ->where('referees.id',$referee->id)
                        ->get();
                        // dd($agentrequests)->toArray();
        return view('RefereeManagement.agentRequestList', compact('agentrequests'));
    }
    public function agentAccept($id)
    {
        $user = User::findOrFail($id);
        //dd($id);
        $user->status = 2;
        $rfcode = strtoupper($user->referee_code);
        $referee = Referee::where('referee_code', '=', $rfcode)->first();
        $user->referee_code = $rfcode;
        $user->update();
        $agent = new Agent();
        $agent->user_id = $id;
        $agent->referee_id = $referee->id;
        $agent->save();
        return redirect()->back()->with('success', 'Accepted!');
    }

    public function agentDecline($id)
     {
        $user = User::findOrFail($id);
        $user->status = '0';//0=null,1=pending,2=accept
        $user->request_type =null;
        $user->referee_code=null;
        $user->update();

        return redirect()->back()->with('success', 'Decline');
     }

    public function agentAcceptold($id, $client_id)
    {
        $refereerequest = User::findOrFail($id);
        $refereerequest->status = 'accept'; //0=pending,1=accept,2=decline
        $refereerequest->update();
        // $string = 'AG-00001';

        $countAgentID = User::count('agent_id');


        if ($countAgentID == 0) {
            $agent = User::findOrFail($client_id);
            $agent->status = 'agent';
            // $agent->agent_id= $string.intval($newid)+1;
            $agent->agent_id = 'AG00001';
            $agent->user_status = 'active'; //0=inactive,1=active
            $agent->parent_id = $refereerequest->operationstaff_id;
            $agent->update();
            return redirect()->back();
        } else {
            $LatestAgentID = User::max('agent_id');
            $newid = substr($LatestAgentID, 2, 5);
            // $string = substr($LatestAgentID, 0, 2);

            $agent = User::findOrFail($client_id);
            $agent->status = 'agent';
            $agent->agent_id = 'AG' . intval($newid) + 1;
            // $agent->agent_id= 'AG1';
            $agent->user_status = 'active'; //0=inactive,1=active
            $agent->parent_id = $refereerequest->operationstaff_id;
            $agent->update();
            return redirect()->back();
        }
    }
    // public function agentDecline($id)
    // {
    //     $refereerequest = Requests::findOrFail($id);
    //     $refereerequest->status = 'Decline';//0=pending,1=accept,2=decline
    //     $refereerequest->update();
    //     return redirect()->back();
    // }

    public function twoDmanage()
    {

        return view('RefereeManagement.twoDManage');
    }

    public function twoDManageCreate(Request $request)
    {
        $td_lists = $request->twod; // json string
        $td_lists =  json_decode(json_encode($td_lists));
        $date = Carbon::Now();
        $time = Carbon::Now()->toTimeString();
        $user = auth()->user()->id;
        if($user){
            $referee = Referee::where('user_id', $user)->first();
        if($time > 12){
            foreach ($td_lists as $td_lists) {
                $twod = new Twod();
               //  intval($num)
               $maxAmt = $td_lists->maxAmount;
               $comp = $td_lists->compensation;
               $twod->referee_id = $referee->id;
               $twod->number = $td_lists->twodNumber;
               $twod->max_amount = intval($maxAmt);
               $twod->Compensation = intval($comp);
               $twod->date = $date;
               $twod->round =  'Evening';
               $twod->save();
            }
        }
        else{
            foreach ($td_lists as $td_lists) {
                $twod = new Twod();
               //  intval($num)
                $maxAmt = $td_lists->maxAmount;
                $comp = $td_lists->compensation;
                $twod->referee_id = $referee->id;
                $twod->number = $td_lists->twodNumber;
                $twod->max_amount = intval($maxAmt);
                $twod->Compensation = intval($comp);
                $twod->date = $date;
                $twod->round =  'Morning';
                $twod->save();
            }
        }
        }
    }


    public function tDListToAgentsAndReferee()
    {
        $user = auth()->user()->id;
        $currenDate = Carbon::now()->toDateString();
        $time = Carbon::Now()->toTimeString();
        if ($user) {
            // $agent = Agent::where('user_id', $user->id)->first();
            $referee = Referee::where('user_id', $user)->first();
            // dd($referee->toArray());
            // dd($referee);
            if ($time > 12) {
            $twoD_sale_lists = DB::select("SELECT aa.id,aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM ( SELECT * FROM twods t where referee_id = '$referee->id' ORDER BY id DESC LIMIT 100 )sub ORDER BY id ASC) aa
            LEFT join agents on aa.referee_id = agents.id
            LEFT join twodsalelists ts on ts.twod_id = aa.id
            and ts.status = 1
            where aa.referee_id = '$referee->id'
            and aa.date = '$currenDate'
            and aa.round = 'Evening'
            group by aa.number");

            // $twoD_sale_lists = json_decode(json_encode ( $twoD_sale ) , true);
            // $twoD_sale_lists = collect($twoD_sale)->sortBy('id')->toArray();
            // $twoD_sale_lists->sortByDesc('score');
            } else {
                $twoD_sale_lists = DB::select("SELECT aa.id,aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM ( SELECT * FROM twods t where referee_id = '$referee->id' ORDER BY id DESC LIMIT 100 )sub ORDER BY id ASC) aa
            LEFT join agents on aa.referee_id = agents.id
            LEFT join twodsalelists ts on ts.twod_id = aa.id
            and ts.status = 1
            where aa.referee_id = '$referee->id'
            and aa.date = '$currenDate'
            and aa.round = 'Morning'
            group by aa.number");
            //  $twoD_sale_lists = json_decode(json_encode ( $twoD_sale ) , true);
            //  $twoD_sale_lists = collect($twoD_sale)->sortBy('id')->toArray();
            }
        }
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = 'Updated';
        $pusher->trigger('testing-channel.' . $referee->id, 'App\\Events\\testing',  $data);
        return response()->json([
            'status' => 200,
            'data' => ['salesList' => $twoD_sale_lists]
        ]);
    }

    public function SendToAgentsAndReferee1()
    {
        return view('test');
    }



    // dailysalebook start
    public function dailysalebook(){
        $agents = Agent::get();
        //dd($agents->toArray());
        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $agenttwodsaleList = Twodsalelist::select('twodsalelists.id','twodsalelists.agent_id','twodsalelists.sale_amount','twodsalelists.status','twods.number',
                                'twods.compensation','twods.round','users.name')
                                ->join('twods','twods.id','twodsalelists.twod_id')
                                ->join('agents','agents.id','twodsalelists.agent_id')
                                ->join('users','users.id','agents.user_id')
                                ->groupBy('twodsalelists.agent_id')
                                ->orderBy('twodsalelists.id','desc')
                                ->where('twods.referee_id',$referee->id)
                                ->where('twodsalelists.status',0)
                                ->where('twods.referee_id',$referee->id)
                                ->get();
        $agenttwodsalenumber = Twodsalelist::select('twodsalelists.id','twodsalelists.agent_id','twodsalelists.sale_amount','twodsalelists.status','twods.number',
        'twods.compensation','twods.round','users.name')
        ->join('twods','twods.id','twodsalelists.twod_id')
        ->join('agents','agents.id','twodsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->where('twods.referee_id',$referee->id)
        ->where('twodsalelists.status',0)
        ->where('twods.referee_id',$referee->id)
        ->get();
                            //dd($agenttwodsalenumber->toArray());
        $agentlonepyinesalelist = Lonepyinesalelist::select('lonepyinesalelists.id','lonepyines.number','lonepyines.compensation','lonepyines.round','lonepyinesalelists.sale_amount',
                            'lonepyinesalelists.agent_id','users.name','lonepyinesalelists.status')
                            ->join('lonepyines','lonepyinesalelists.lonepyine_id','lonepyines.id')
                            ->join('agents','agents.id','lonepyinesalelists.agent_id')
                            ->join('users','users.id','agents.user_id')
                            ->groupBy('lonepyinesalelists.agent_id')
                            ->orderBy('lonepyinesalelists.id','desc')
                            ->where('lonepyines.referee_id',$referee->id)
                            ->where('lonepyinesalelists.status',0)
                            ->get();
                            //dd($agentlonepyinesalelist->toArray());

        $agentlonepyinesalenumber = Lonepyinesalelist::select('lonepyinesalelists.id','lonepyines.number','lonepyines.compensation','lonepyines.round','lonepyinesalelists.sale_amount',
        'lonepyinesalelists.agent_id','users.name','lonepyinesalelists.status')
        ->join('lonepyines','lonepyinesalelists.lonepyine_id','lonepyines.id')
        ->join('agents','agents.id','lonepyinesalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->where('lonepyines.referee_id',$referee->id)
        ->where('lonepyinesalelists.status',0)
        ->get();
                        //dd($agentlonepyinesalelist->toArray());

        $agentthreedsalelist = Threedsalelist::select('threedsalelists.id','threedsalelists.agent_id','threedsalelists.sale_amount','threedsalelists.status',
                        'threeds.number','threeds.compensation','users.name')
                            ->join('threeds','threeds.id','threedsalelists.threed_id')
                            ->join('agents','agents.id','threedsalelists.agent_id')
                            ->join('users','users.id','agents.user_id')
                            ->groupBy('threedsalelists.agent_id')
                           ->orderBy('threedsalelists.id','desc')
                            ->where('threedsalelists.status',0)
                        ->where('threeds.referee_id',$referee->id)
                            ->get();

        $agentthreedsalenumber = Threedsalelist::select('threedsalelists.id','threedsalelists.agent_id','threedsalelists.sale_amount','threedsalelists.status',
            'threeds.number','threeds.compensation','users.name')
        ->join('threeds','threeds.id','threedsalelists.threed_id')
        ->join('agents','agents.id','threedsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->where('threedsalelists.status',0)
        ->where('threeds.referee_id',$referee->id)
        ->get();
        //dd($threedlist->toArray());
        $acceptstatus = $agenttwodsaleList->where('status',1);

        //chart
        $tdy_date=Carbon::now()->toDateString();
        $time=Carbon::now()->toTimeString();
        if($time>12){
            $round='Evening';
        }else{
            $round='Morning';
        }
        $agents = Agent::get();
        //dd($agents->toArray());
        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $twod_salelists = Twodsalelist::select('number','sale_amount')->orderBy('sale_amount', 'DESC')->join('agents','twodsalelists.agent_id','agents.id')->where('twods.date',$tdy_date)
        ->where('twods.round',$round)->where('agents.referee_id',$referee->id)->join('twods','twods.id','twodsalelists.twod_id')->limit(10)->get();

        $lp_salelists = Lonepyinesalelist::select('number','sale_amount')->orderBy('sale_amount', 'DESC')->join('agents','lonepyinesalelists.agent_id','agents.id')->where('lonepyines.date',$tdy_date)
        ->where('lonepyines.round',$round)->where('agents.referee_id',$referee->id)->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')->limit(10)->get();

        $threed_salelists = Threedsalelist::select('number','sale_amount')->orderBy('sale_amount', 'DESC')->join('agents','threedsalelists.agent_id','agents.id')->where('threeds.date',$tdy_date)->where('agents.referee_id',$referee->id)->join('threeds','threeds.id','threedsalelists.threed_id')->limit(10)->get();

        $rate = DB::Select("SELECT t.compensation FROM threeds t where referee_id = $referee->id ORDER BY id DESC LIMIT 1");
        //twodnumberlist for an agent
        $grouped = $agenttwodsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['number']];
        });
        $numbergroup=$grouped->toArray();

        $grouped = $agenttwodsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['id']];
        });
        $idgroup=$grouped->toArray();

        $grouped = $agenttwodsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['compensation']];
        });
        $compengroup=$grouped->toArray();

        $grouped = $agenttwodsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['sale_amount']];
        });
        $salegroup=$grouped->toArray();


        //for lonepyine
        $grouped = $agentlonepyinesalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['number']];
        });
        $lp_numbergroup=$grouped->toArray();

        $grouped = $agentlonepyinesalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['id']];
        });
        $lp_idgroup=$grouped->toArray();


        $grouped = $agentlonepyinesalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['compensation']];
        });
        $lp_compengroup=$grouped->toArray();

        $grouped = $agentlonepyinesalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['sale_amount']];
        });
        $lp_salegroup=$grouped->toArray();

        //for 3D
        $grouped = $agentthreedsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['number']];
        });
        $threed_numbergroup=$grouped->toArray();

        $grouped = $agentthreedsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['id']];
        });
        $threed_idgroup=$grouped->toArray();

        $grouped = $agentthreedsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['compensation']];
        });
        $threed_compengroup=$grouped->toArray();

        $grouped = $agentthreedsalenumber->mapToGroups(function ($item, $key) {
            return [$item['name'] => $item['sale_amount']];
        });
        $threed_salegroup=$grouped->toArray();

        return view('RefereeManagement.dailysalebook', compact('agents','twod_salelists','numbergroup','compengroup',
        'salegroup','lp_numbergroup','lp_compengroup','lp_salegroup','lp_salelists','threed_numbergroup','threed_compengroup','threed_salegroup',
        'threed_salelists','agenttwodsaleList','agenttwodsalenumber', 'acceptstatus', 'agentlonepyinesalelist','agentthreedsalelist','idgroup','lp_idgroup','threed_idgroup','rate'));
    }
    public function update(Request $request){
        $currenDate = Carbon::now()->toDateString();
        $time = Carbon::Now()->toTimeString();
        foreach($request->id as $re){
            Twodsalelist::where('id',$re)
            ->update(["status" => 3]);
        }
        if($time > 12){
            $amtForA = DB::select("SELECT t.round,ts.agent_id,
            SUM(ts.sale_amount) as SalesAmount,a.commision,(cio.coin_amount + (a.commision/100)*  SUM(ts.sale_amount) -SUM(ts.sale_amount)) as UpdateAmt
                FROM twodsalelists ts
                left join twods t on t.id = ts.twod_id
                left join agents a ON a.id = ts.agent_id
                left join cashin_cashouts cio on ts.agent_id = cio.agent_id
                and t.round = 'Evening' and ts.status = '3' and t.date = '$currenDate'
                group by ts.agent_id");
            //dd($amtForA);
            $amtforR = DB::select("SELECT (COALESCE(SUM(ts.sale_amount),0) + COALESCE(re.main_cash,0)) - (a.commision/100)*  (COALESCE(SUM(ts.sale_amount),0))  totalSale ,re.id,
                        ((a.commision/100)*  (COALESCE(SUM(ts.sale_amount),0))
                                    ) as Commission
                From agents a left join referees re on re.id = a.referee_id
                right join twodsalelists ts on ts.agent_id = a.id
                left join twods t on t.id = ts.twod_id
                where ts.status = 3 and t.round = 'Evening' and  t.date = '$currenDate'
                Group By re.id;");
            // dd($amtforR);
            foreach($amtforR as $amtR){
                // dd($amtR->totalSale);
                Referee::where('id',$amtR->id)->update(["main_cash"=>$amtR->totalSale]);
            }
            foreach($amtForA as $amt){
                dump($amt);
                CashinCashout::where('agent_id',$amt->agent_id)->update(["coin_amount"=>$amt->UpdateAmt]);
            }
        }
            else{
                $amtForA = DB::select("SELECT t.round,ts.agent_id,(SUM(ts.sale_amount)) as SalesAmount,a.commision,
            (cio.coin_amount + (a.commision/100)*SUM(ts.sale_amount) - SUM(ts.sale_amount)) as UpdateAmt
                FROM twodsalelists ts
                left join twods t on t.id = ts.twod_id
                left join agents a ON a.id = ts.agent_id
                left join cashin_cashouts cio on ts.agent_id = cio.agent_id
                where t.round = 'Morning' and ts.status = '3' and t.date = '$currenDate'
                group by ts.agent_id");
                //  dd($amtForA);

                $amtforR = DB::select("SELECT (COALESCE(SUM(ts.sale_amount),0) + COALESCE(re.main_cash,0)) - (a.commision/100)*  (COALESCE(SUM(ts.sale_amount),0))  totalSale ,re.id,
                ((a.commision/100)*  (COALESCE(SUM(ts.sale_amount),0))) as Commission
                From agents a left join referees re on re.id = a.referee_id
                right join twodsalelists ts on ts.agent_id = a.id
                left join twods t on t.id = ts.twod_id
                where ts.status = 3 and t.round = 'Morning' and  t.date = '$currenDate'
                Group By re.id;");
                // dd($amtforR);
                foreach($amtforR as $amtR){
                    //  dd($amtR->totalSale);
                    Referee::where('id',$amtR->id)->update(["main_cash"=>$amtR->totalSale]);
                }
                foreach($amtForA as $amt){
                    // dd($amt->UpdateAmt);
                    CashinCashout::where('agent_id',$amt->agent_id)->update(["coin_amount"=>$amt->UpdateAmt]);
                }
            }
            foreach($request->id as $re){
                Twodsalelist::where('id',$re)
                ->update(["status" => 1]);
            }

            $options = array(
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
                );
                $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
                );
                $user = auth()->user()->id;
                $referee =Referee::where('user_id',$user)->first();
                $data = 'Acceped';
                $pusher->trigger('accepted-channel.'.$referee->id, 'App\\Events\\AcceptedSMS',  $data);
        return redirect()->back()->with('accept', 'Accepted!');
    }
    public function lpupdate(Request $request){

        $currenDate = Carbon::now()->toDateString();

        $time = Carbon::Now()->toTimeString();

        foreach($request->id as $re){

            Lonepyinesalelist::where('id',$re)

            ->update(["status" => 3]);

        }

        if($time > 12){

            $amtForA = DB::select("SELECT ls.agent_id, (SUM(ls.sale_amount)) as SalesAmount,a.commision,
            (cio.coin_amount + (a.commision/100)*  SUM(ls.sale_amount)) - (SUM(ls.sale_amount)) as UpdateAmt
            FROM lonepyinesalelists ls
            left join agents a ON a.id = ls.agent_id
            left join lonepyines l on l.id = ls.lonepyine_id
            left join cashin_cashouts cio on ls.agent_id = cio.agent_id
            where l.round = 'Evening' and ls.status = '3' and l.date = '$currenDate'
            group by ls.agent_id");
            $amtforR = DB::select("Select (COALESCE(SUM(ls.sale_amount),0) + COALESCE(re.main_cash,0) - (a.commision/100)* (COALESCE(SUM(ls.       sale_amount),0))) totalSale ,re.id
            From agents a left join referees re on re.id = a.referee_id
            left join lonepyinesalelists ls on ls.agent_id = a.id
            left join lonepyines l on l.id = ls.lonepyine_id
            where ls.status = 3 and l.round = 'Evening' and l.date = '$currenDate'
            Group By re.id");
            // dd($amtforR);
            foreach($amtforR as $amtR){
                Referee::where('id',$amtR->id)->update(["main_cash"=>$amtR->totalSale]);
            }
            foreach($amtForA as $amt){
                CashinCashout::where('agent_id',$amt->agent_id)->update(["coin_amount"=>$amt->UpdateAmt]);
            }
        }
            else{
                $amtForA = DB::select("SELECT ls.agent_id,(SUM(ls.sale_amount)) as SalesAmount,a.commision,
                (cio.coin_amount + (a.commision/100)*  (SUM(ls.sale_amount) - SUM(ls.sale_amount))) as UpdateAmt
                FROM lonepyinesalelists ls
                left join agents a on a.id = ls.agent_id
                left join lonepyines l on l.id = ls.lonepyine_id
                left join cashin_cashouts cio on ls.agent_id = cio.agent_id
                where l.round = 'Morning' and ls.status = '1' and l.date = '$currenDate'
                group by ls.agent_id");
                $amtforR = DB::select("SELECT (COALESCE(SUM(ls.sale_amount),0) + COALESCE(re.main_cash,0)) totalSale ,re.id
                From agents a left join referees re on re.id = a.referee_id
                left join lonepyinesalelists ls on ls.agent_id = a.id
                left join lonepyines l on l.id = ls.lonepyine_id
                where ls.status = 3 and l.round = 'Morning' and l.date = '$currenDate'
                Group By re.id");
                // dd($amtforR);
                foreach($amtforR as $amtR){
                    Referee::where('id',$amtR->id)->update(["main_cash"=>$amtR->totalSale]);
                }
                foreach($amtForA as $amt){
                    // dd($amt->UpdateAmt);
                    CashinCashout::where('agent_id',$amt->agent_id)->update(["coin_amount"=>$amt->UpdateAmt]);
                }
            }
            foreach($request->id as $re){
                Lonepyinesalelist::where('id',$re)
                ->update(["status" => 1]);
            }
            $options = array(

                'cluster' => env('PUSHER_APP_CLUSTER'),

                'encrypted' => true

                );

                $pusher = new Pusher(

                env('PUSHER_APP_KEY'),

                env('PUSHER_APP_SECRET'),

                env('PUSHER_APP_ID'),

                $options

                );

                $user = auth()->user()->id;

                $referee =Referee::where('user_id',$user)->first();

                $data = 'Acceped';

                $pusher->trigger('accepted-channel.'.$referee->id, 'App\\Events\\AcceptedSMS',  $data);

        return redirect()->back()->with('accept', 'Accepted!');

    }

    public function threedupdate(Request $request){

        $currenDate = Carbon::now()->toDateString();

        foreach($request->id as $re){

         Threedsalelist::where('id',$re)

            ->update(["status" => 3]);

        }



            $amtForA = DB::select("SELECT tds.agent_id, (COALESCE(SUM(tds.sale_amount),0)) as SalesAmount,a.commision,

            (cio.coin_amount + (a.commision/100)*  (COALESCE(SUM(tds.sale_amount),0)) - COALESCE(SUM(tds.sale_amount),0)

            ) as UpdateAmt

            FROM threedsalelists tds

            left join agents a ON a.id = tds.agent_id

            left join threeds td on td.id = tds.threed_id

            left join cashin_cashouts cio on tds.agent_id = cio.agent_id

            where tds.status = '3' and td.date = '$currenDate'

            group by tds.agent_id");



            $amtforR = DB::select("Select (COALESCE(SUM(tds.sale_amount),0) + COALESCE(re.main_cash,0) - (a.commision/100)*  (COALESCE(SUM(tds.sale_amount),0)) ) totalSale ,re.id

            From agents a left join referees re on re.id = a.referee_id

            left join threedsalelists tds on tds.agent_id = a.id

            left join threeds td on td.id = tds.threed_id

            where tds.status = 3 and td.date = '$currenDate'

            Group By re.id");

            // dd($amtforR);

            foreach($amtforR as $amtR){

                //  dd($amtR->totalSale);

                Referee::where('id',$amtR->id)->update(["main_cash"=>$amtR->totalSale]);

            }

            foreach($amtForA as $amt){

                // dd($amt->UpdateAmt);

                CashinCashout::where('agent_id',$amt->agent_id)->update(["coin_amount"=>$amt->UpdateAmt]);

            }

            foreach($request->id as $re){

                Threedsalelist::where('id',$re)

                   ->update(["status" => 1]);

               }

               $options = array(

                'cluster' => env('PUSHER_APP_CLUSTER'),

                'encrypted' => true

                );

                $pusher = new Pusher(

                env('PUSHER_APP_KEY'),

                env('PUSHER_APP_SECRET'),

                env('PUSHER_APP_ID'),

                $options

                );

                $user = auth()->user()->id;

                $referee =Referee::where('user_id',$user)->first();

                $data = 'Acceped';

                $pusher->trigger('accepted-channel.'.$referee->id, 'App\\Events\\AcceptedSMS',  $data);

        return redirect()->back()->with('accept', 'Accepted!');

    }




 //decline
    public function declineTwod(Request $request){
        foreach($request->id as $re){
            $twoDSalesList = Twodsalelist::where('id',$re)
            ->update(["status" => 2]);
        }
        return redirect()->back()->with('declined', 'Declined!');
    }
    public function declinelp(Request $request){
        foreach($request->id as $re){
            $lpSalesList = Lonepyinesalelist::where('id',$re)
            ->update(["status" => 2]);
        }
        return redirect()->back()->with('declined', 'Declined!');
    }
    public function declineThreed(Request $request){
        foreach($request->id as $re){
            $lpSalesList = Threedsalelist::where('id',$re)
            ->update(["status" => 2]);
        }
        return redirect()->back()->with('declined', 'Declined!');
    }

    //dailysalebook end

    public function twodlist()
    {
        $user = auth()->user()->id;
        $currenDate = Carbon::now()->toDateString();
        $time = Carbon::Now()->toTimeString();

        if ($user) {
            $referee = Referee::where('user_id', $user)->first();
            if ($time > 12) {
            $twoD_sale_lists = DB::select("SELECT aa.id,aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM ( SELECT * FROM twods t where referee_id = '$referee->id' ORDER BY id DESC LIMIT 100 )sub ORDER BY id ASC) aa
            LEFT join agents on aa.referee_id = agents.id
            LEFT join twodsalelists ts on ts.twod_id = aa.id
            and ts.status = 1
            where aa.referee_id = '$referee->id'
            and aa.date = '$currenDate'
            and aa.round = 'Evening'
            group by aa.number");
            } else {
                $twoD_sale_lists = DB::select("SELECT aa.id,aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM ( SELECT * FROM twods t where referee_id = '$referee->id' ORDER BY id DESC LIMIT 100 )sub ORDER BY id ASC) aa
            LEFT join agents on aa.referee_id = agents.id
            LEFT join twodsalelists ts on ts.twod_id = aa.id
            and ts.status = 1
            where aa.referee_id = '$referee->id'
            and aa.date = '$currenDate'
            and aa.round = 'Morning'
            group by aa.number");
            }
            return response()->json([
                'status' => 200,
                'data' => ['salesList' => $twoD_sale_lists]
            ]);
        }
    }

    public function lonepyinelist()
    {
        $user = auth()->user()->id;
        $currenDate = Carbon::now()->toDateString();
        $time = Carbon::Now()->toTimeString();
        if($user){
            $referee =Referee::where('user_id',$user)->first();
            $lonepyaing_sale_lists = DB::select("Select aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM
             ( SELECT * FROM lonepyines t where referee_id = '$referee->id'
             ORDER BY id DESC LIMIT 20 )sub ORDER BY id ASC) aa LEFT join agents on
             aa.referee_id = agents.id LEFT join lonepyinesalelists ts on
             ts.lonepyine_id = aa.id where aa.referee_id = '$referee->id ' and aa.date = '$currenDate' group by aa.number, aa.max_amount , agents.id , aa.max_amount , aa.compensation");

            return response()->json([
                'status' => 200,
                'data' => ['salesList' => $lonepyaing_sale_lists]
            ]);
        }

    }

    public function announcement(Request $request){
        $user = auth()->user()->id;

        $referee =Referee::where('user_id',$user)->update(['remark'=>$request->remark]);
        $refereeID =Referee::where('user_id',$user)->first();
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
            );
            $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
            );
                // $data['message'] = 'Hello XpertPhp';
        $pusher->trigger('announce-referee.'.$refereeID->id, 'App\\Events\\AnnouncementForAgents',  $refereeID->remark);
        return redirect()->back();
    }


    public function refereeProfile(){
        $user = auth()->user()->id;
        $referee =Referee::where('user_id',$user)->first();
        $referee_maincash_hitories = MaincashHitory::where('referee_id', $referee->id)->orderBy('updated_at', 'desc')->get();

        $agent_cash_histories = AgentcashHistory::where('referee_id', $referee->id)->with('agent', 'agent.user')->orderBy('updated_at', 'desc')->get();

        $agentsaleamounts= DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount))maincash ,re.id,a.id From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 where re.id= $referee->id Group By a.id;");
        $agentsaleamounts= DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount))maincash ,re.id,a.id From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 where re.id= $referee->id Group By a.id limit 5;");
        //$agentsaleamounts->limit(3);
        $agents=DB::select("Select a.id,u.name,u.phone
                            From agents a JOIN referees re on re.id = a.referee_id
                            LEFT JOIN users u on u.id = a.user_id
                            where re.id=$referee->id Group By a.id,u.name,u.phone;");

        $twod=Twodsalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','twodsalelists.agent_id')
                    ->where('agents.referee_id',$referee->id)
                    ->where('twodsalelists.status',1)
                    ->groupBy('agents.id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();

        $threed=Threedsalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','threedsalelists.agent_id')
                    ->where('agents.referee_id',$referee->id)
                    ->where('threedsalelists.status',1)
                    ->groupBy('agents.id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();

        $lonepyine=Lonepyinesalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','lonepyinesalelists.agent_id')
                    ->where('agents.referee_id',$referee->id)
                    ->where('lonepyinesalelists.status',1)
                    ->groupBy('agents.id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();
        $output = array_merge($twod,$threed,$lonepyine);
        $sum=0;
            foreach($output as $op){

                $sum+=$op['Amount'];
            }
        $results = array_reduce($output, function($carry, $item){
        if(!isset($carry[$item['id']])){
        $carry[$item['id']] = ['id'=>$item['id'],'name'=>$item['name'],'phone'=>$item['phone'],'Amount'=>$item['Amount']];
        } else {
        $carry[$item['id']]['Amount'] += $item['Amount'];
        }
        return $carry;
        });
        return view('RefereeManagement.referee_profile', compact('referee','agents','results','sum','agentsaleamounts', 'referee_maincash_hitories','agent_cash_histories'));
    }
}
