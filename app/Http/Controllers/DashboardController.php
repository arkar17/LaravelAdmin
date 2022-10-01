<?php

namespace App\Http\Controllers;

use App\Events\twodbetlist;
use PDF;
use Throwable;
use Carbon\Carbon;
use App\Models\Twod;
use App\Models\User;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Lonepyine;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use App\Models\Threedsalelist;
use App\Models\Lonepyinesalelist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function sysdashboard()
    {
        $user = Auth::user();
        $tdy_date=Carbon::now()->toDateString();
        $time=Carbon::now()->toTimeString();
        if($time>16){
            $round='Evening';
        }else{
            $round='Morning';
        }

        if($user->hasRole('system_admin')){
                $users = User::all();
                $referees = Referee::all();
                $agents = Agent::all();
                $totalsaleamounts = DB::select("SELECT (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount)) maincash ,re.id
                                                FROM agents a LEFT JOIN referees re ON re.id = a.referee_id
                                                LEFT JOIN twodsalelists ts ON ts.agent_id = a.id AND ts.status = 1
                                                LEFT JOIN threedsalelists tr ON tr.agent_id = a.id AND tr.status = 1
                                                LEFT JOIN lonepyinesalelists ls ON ls.agent_id = a.id AND ls.status = 1
                                                Group By re.id;");

                $twodtotal = (int)Twodsalelist::where('status', '=', '1')->sum('sale_amount');
                $threedtotal = (int)Threedsalelist::where('status', '=', '1')->sum('sale_amount');
                $lonepyinetotal = (int)Lonepyinesalelist::where('status', '=', '1')->sum('sale_amount');
                $sum = $twodtotal + $threedtotal + $lonepyinetotal;

                $twod_salelists = Twodsalelist::select('number', 'sale_amount')
                                                ->join('twods', 'twods.id', 'twodsalelists.twod_id')
                                                ->where('twods.date',$tdy_date)
                                                ->where('twods.round',$round)
                                                ->limit(10)->get();
                $lp_salelists = Lonepyinesalelist::select('number', 'sale_amount')
                                                ->orderBy('sale_amount', 'DESC')
                                                ->join('lonepyines', 'lonepyines.id', 'lonepyinesalelists.lonepyine_id')
                                                ->where('lonepyines.date',$tdy_date)
                                                ->where('lonepyines.round',$round)
                                                ->limit(10)->get();
                $refereesaleamounts = DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount))maincash ,re.id From agents a LEFT join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 Group By re.id ORDER BY maincash DESC;");

                return view('dashboard', compact('users', 'referees','refereesaleamounts', 'twod_salelists','agents', 'lp_salelists', 'totalsaleamounts', 'sum'));
        }else{

            $referee =Referee::where('user_id',$user->id)->first();
            $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();

            $twod_total = 0;
            $threed_total = 0;
            $lonepyine_total = 0;

                $twod_salelist = Twodsalelist::where('status', '1')->whereIn('agent_id', $agents)->with('twod')->whereHas('twod', function ($q) use
                ($current_date) {
                    $q->where('date', $current_date);
                })->first();

                if ($twod_salelist == null) {
                    $twod_total = 0;
                }
                else{
                    $twod_total +=$twod_salelist->sale_amount;
                }
                // dd($twod_salelist);

                $threed_salelist = Threedsalelist::where('status', '1')->whereIn('agent_id', $agents)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->first();
                if ($threed_salelist == null) {
                    $threed_total = $threed_total + 0;
                }
                else{
                    $threed_total +=  $threed_salelist->sale_amount;
                }



                $lonepyine_salelist = Lonepyinesalelist::where('status', '1')->whereIn('agent_id', $agents)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->first();
                if ($lonepyine_salelist == null) {
                    $lonepyine_total = $lonepyine_total + 0;
                }
                else{
                    $lonepyine_total += $lonepyine_salelist->sale_amount;
                }


            $twodtotal =  Twodsalelist::select('twods.referee_id','agents.id',
                          DB::raw('SUM(twodsalelists.sale_amount )'),
                          DB::raw('(agents.commision/100) * SUM(twodsalelists.sale_amount) as Commission'),
                          DB::raw('( SUM(twodsalelists.sale_amount ) - ((agents.commision/100) * SUM(twodsalelists.sale_amount) )) As Amount'  ))
                        ->join('twods','twods.id','twodsalelists.twod_id')
                        ->join('agents','twodsalelists.agent_id','agents.id')
                        ->where('twods.date',$current_date)
                        ->where('twods.referee_id',$referee->id)
                        ->where('twodsalelists.status',1)
                        ->groupBy('twods.referee_id','twodsalelists.agent_id')
                        ->get()->toArray();
            // dd($twodtotal);
            $lonepyinetotal =  Lonepyinesalelist::select('lonepyines.referee_id','agents.id',
                          DB::raw('(agents.commision/100) * SUM(lonepyinesalelists.sale_amount) as Commission'),
                          DB::raw('SUM(lonepyinesalelists.sale_amount )'),
                          DB::raw('( SUM(lonepyinesalelists.sale_amount ) - ((agents.commision/100) * SUM(lonepyinesalelists.sale_amount) )) As Amount'  ))
                        ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
                        ->join('agents','lonepyinesalelists.agent_id','agents.id')
                        ->where('lonepyines.date',$current_date)
                        ->where('lonepyines.referee_id',$referee->id)
                        ->where('lonepyinesalelists.status',1)
                        ->groupBy('lonepyines.referee_id')
                        ->get()->toArray();
            // dd($lonepyinetotal);
            $threedtotal =  Threedsalelist::select('threeds.referee_id','agents.id',
                          DB::raw('SUM(threedsalelists.sale_amount )'),
                          DB::raw('(agents.commision/100) * SUM(threedsalelists.sale_amount) as Commission'),
                          DB::raw('( SUM(threedsalelists.sale_amount ) - ((agents.commision/100) * SUM(threedsalelists.sale_amount) )) As Amount'  ))
                            ->join('threeds','threeds.id','threedsalelists.threed_id')
                            ->join('agents','threedsalelists.agent_id','agents.id')
                            ->where('threedsalelists.date',$current_date)
                            ->where('threeds.referee_id',$referee->id)
                            ->where('threedsalelists.status',1)
                            ->groupBy('threeds.referee_id')
                            ->get()->toArray();
            // dd($threedtotal);
            $output = array_merge($twodtotal,$lonepyinetotal,$threedtotal);


            $sum = array_reduce($output, function($carry, $item){
                if(!isset($carry[$item['referee_id']])){
                $carry[$item['referee_id']] = ['Amount'=>$item['Amount'], 'Commission'=>$item['Commission']];
                } else {
                $carry[$item['referee_id']]['Amount'] += $item['Amount'];
                $carry[$item['referee_id']]['Commission'] += $item['Commission'];
                }
                return $carry;
                });



            $winningAmttwod = Twodsalelist::select('twods.referee_id',
                            DB::raw('(twods.compensation) * SUM(twodsalelists.sale_amount) as Winning'))
                            ->join('twods','twods.id','twodsalelists.twod_id')
                            ->join('agents','twodsalelists.agent_id','agents.id')
                            ->where('twods.date',$current_date)
                            ->where('twods.referee_id',$referee->id)
                            ->where('twodsalelists.status',1)
                            ->where('twodsalelists.winning_status',1)
                            ->groupBy('twods.referee_id','twods.number')
                            ->get()->toArray();
            //dd($winningAmttwod);
            $winningAmtlp = Lonepyinesalelist::select('lonepyines.referee_id',
                            DB::raw('(lonepyines.compensation) * SUM(lonepyinesalelists.sale_amount) as Winning'))
                            ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
                            ->join('agents','lonepyinesalelists.agent_id','agents.id')
                            ->where('lonepyines.date',$current_date)
                            ->where('lonepyines.referee_id',$referee->id)
                            ->where('lonepyinesalelists.status',1)
                            ->where('lonepyinesalelists.winning_status',1)
                            ->groupBy('lonepyines.referee_id','lonepyines.number')
                            ->get()->toArray();
            // dd($winningAmtlp);

            $winningAmtthreed = Threedsalelist::select('threeds.referee_id',
                            DB::raw('(threeds.compensation) * SUM(threedsalelists.sale_amount) as Winning'))
                            ->join('threeds','threeds.id','threedsalelists.threed_id')
                            ->join('agents','threedsalelists.agent_id','agents.id')
                            ->where('threedsalelists.date',$current_date)
                            ->where('threeds.referee_id',$referee->id)
                            ->where('threedsalelists.status',1)
                            ->where('threedsalelists.winning_status',1)
                            ->groupBy('threeds.referee_id','threeds.number')
                            ->get()->toArray();

            $winning = array_merge($winningAmttwod,$winningAmtlp,$winningAmtthreed);


            $winningAmt = array_reduce($winning, function($carry, $item){
                if(!isset($carry[$item['referee_id']])){
                $carry[$item['referee_id']] = ['Winning'=>$item['Winning']];
                } else {
                $carry[$item['referee_id']]['Winning'] += $item['Winning'];
                }
                return $carry;
                });

            foreach($sum as $ss){
                if($winningAmt == null){
                    $profit = $ss['Amount'] - 0;
                }
                else{
                    foreach($winningAmt as $profit){
                        $profit = $ss['Amount'] - $profit['Winning'];
                    }
                }
            }




            $referee =Referee::where('user_id',$user->id)->first();
            $refe_twod_salelists = Twodsalelist::select('number', 'sale_amount')->orderBy('sale_amount', 'DESC')->where('twods.date',$tdy_date)->where('twodsalelists.status',1)
            ->join('agents','twodsalelists.agent_id','agents.id')->where('agents.referee_id',$referee->id)->join('twods', 'twods.id', 'twodsalelists.twod_id')->limit(10)->get();

            $refe_lp_salelists = Lonepyinesalelist::select('number', 'sale_amount')->orderBy('sale_amount', 'DESC')->where('lonepyines.date',$tdy_date)->where('lonepyinesalelists.status',1)
            ->join('agents','lonepyinesalelists.agent_id','agents.id')->where('agents.referee_id',$referee->id)->join('lonepyines', 'lonepyines.id', 'lonepyinesalelists.lonepyine_id')->limit(10)->get();

            $Declined_twoDList = Twodsalelist::select('twods.number','twods.max_amount','users.name',DB::raw('SUM(twodsalelists.sale_amount)as sales'))
            ->join('twods','twods.id','twodsalelists.twod_id')
            ->join('agents','agents.id','twodsalelists.agent_id')
            ->join('users','users.id','agents.user_id')
            ->where('twods.referee_id',$referee->id)
            ->where('twods.date',$current_date)
            ->where('twodsalelists.status',2)
            ->groupBy('twods.number')
            ->having('twods.max_amount','<=',DB::raw('SUM(twodsalelists.sale_amount)'))
            ->get();

            $Declined_lonepyineList = Lonepyinesalelist::select('lonepyines.number','lonepyines.max_amount','users.name',DB::raw('SUM(lonepyinesalelists.sale_amount)as sales'))
                        ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
                        ->join('agents','agents.id','lonepyinesalelists.agent_id')
                        ->join('users','users.id','agents.user_id')
                        ->where('lonepyines.referee_id',$referee->id)
                        ->where('lonepyines.date',$current_date)
                        ->where('lonepyinesalelists.status',2)
                        ->groupBy('lonepyines.number')
                        ->having('lonepyines.max_amount','<=',DB::raw('SUM(lonepyinesalelists.sale_amount)'))
                        ->get();
                        return view('dashboard', compact( 'sum', 'agents', 'refe_twod_salelists',
                        'refe_lp_salelists', 'Declined_lonepyineList', 'Declined_twoDList','profit'));
                    }
    }

    public function twoddecline_pdf () {

        $user = Auth::user();
        $referee =Referee::where('user_id',$user->id)->first();
        $current_date = Carbon::now('Asia/Yangon')->toDateString();
        $Declined_twoDList =  Twodsalelist::select('twods.number','twods.max_amount','users.name',DB::raw('SUM(twodsalelists.sale_amount)as sales'))
                            ->join('twods','twods.id','twodsalelists.twod_id')
                            ->join('agents','agents.id','twodsalelists.agent_id')
                            ->join('users','users.id','agents.user_id')
                            ->where('twods.referee_id',$referee->id)
                            ->where('twods.date',$current_date)
                            ->where('twodsalelists.status',2)
                            ->groupBy('twods.number')
                            ->having('twods.max_amount','<=',DB::raw('SUM(twodsalelists.sale_amount)'))
                            ->get();
        $pdf = PDF::loadView('RefereeManagement.twoddecline_pdf',compact('Declined_twoDList'));
        return $pdf->download('twod_declinelists.pdf');

    }

    public function lonepyinedecline_pdf () {

        $user = Auth::user();
        $referee =Referee::where('user_id',$user->id)->first();
        $current_date = Carbon::now('Asia/Yangon')->toDateString();
        $Declined_lonepyineList =  Lonepyinesalelist::select('lonepyines.number','lonepyines.max_amount','users.name',
                                                DB::raw('SUM(lonepyinesalelists.sale_amount)as sales'))
                                                ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
                                                ->join('agents','agents.id','lonepyinesalelists.agent_id')
                                                ->join('users','users.id','agents.user_id')
                                                ->where('lonepyines.referee_id',$referee->id)
                                                ->where('lonepyines.date',$current_date)
                                                ->where('lonepyinesalelists.status',2)
                                                ->groupBy('lonepyines.number')
                                                ->having('lonepyines.max_amount','<=',DB::raw('SUM(lonepyinesalelists.sale_amount)'))
                                                ->get();
        $pdf = PDF::loadView('RefereeManagement.lonepyinedecline_pdf',compact('Declined_lonepyineList'));
        return $pdf->download('lonepyine_declinelists.pdf');

    }
}
