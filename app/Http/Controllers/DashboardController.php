<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Twod;
use App\Models\User;
use App\Models\Agent;
use App\Models\Referee;
use PDF;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use App\Models\Lonepyine;
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
        if($time>12){
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
                                                ->orderBy('sale_amount', 'DESC')
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



            $sum = $twod_total+$threed_total+$lonepyine_total;
            // calculating commision start

            //twod commision
                $tdcomission = DB::select("SELECT COALESCE(SUM(ts.sale_amount),0), a.commision ,a.referee_id, (  (a.commision/100) * COALESCE(SUM(ts.sale_amount),0) ) as Commision
                FROM agents a
                left join twodsalelists ts on a.id = ts.agent_id
                left join twods t on t.id = ts.twod_id
                where ts.status = 1
                and t.date = '$current_date'
                and a.referee_id = '$referee->id'
                Group By a.referee_id,a.id;
                ");
                //dd($tdcomission);

                //twod yaw kyay
                $tdpaid_winning = DB::select("SELECT ( t.compensation * SUM(ts.sale_amount) ) totalSale ,re.id, ((a.commision/100)* (COALESCE(SUM(ts.sale_amount),0)) ) as Commission From agents a
                left join referees re on re.id = a.referee_id
                join twodsalelists ts on ts.agent_id = a.id
                join twods t on t.id = ts.twod_id where ts.status = 1 and t.date = '$current_date' and ts.winning_status =1 and a.referee_id = '$referee->id' Group By re.id,t.id;");
                //dd($paid_winning);
                if(count($tdpaid_winning) !=0 && count($tdcomission) !=0){
                    $twodprofit = $twod_total - ($tdcomission[0]->Commision + $tdpaid_winning[0]->totalSale);
                }else{
                    $twodprofit=0;
                }



                //threed commision
                $thdcomission = DB::select("SELECT COALESCE(SUM(ts.sale_amount),0), a.commision ,a.referee_id, (  (a.commision/100) * COALESCE(SUM(ts.sale_amount),0) ) as Commision
                FROM agents a
                left join threedsalelists ts on a.id = ts.agent_id
                left join threeds t on t.id = ts.threed_id
                where ts.status = 1
                and t.date = '$current_date'
                and a.referee_id = '$referee->id'
                Group By a.referee_id,a.id;
                ");
                //dd($thdcomission);

                $thdpaid_winning = DB::select("SELECT ( t.compensation * SUM(ts.sale_amount) ) totalSale ,re.id, ((a.commision/100)* (COALESCE(SUM(ts.sale_amount),0)) ) as Commission From agents a
                left join referees re on re.id = a.referee_id
                join threedsalelists ts on ts.agent_id = a.id
                join threeds t on t.id = ts.threed_id
                where ts.status = 1 and t.date = '$current_date'
                and ts.winning_status =1 and a.referee_id = '$referee->id' Group By re.id,t.id;");

                if(count($thdpaid_winning) !=0 && count($thdcomission) !=0){
                    $threedprofit = $threed_total - ($thdcomission[0]->Commision + $thdpaid_winning[0]->totalSale);
                }else{
                    $threedprofit=0;
                }

                //dd($threedprofit);

                //loonpyine commision
                $lpcomission = DB::select("SELECT COALESCE(SUM(ts.sale_amount),0), a.commision ,a.referee_id, (  (a.commision/100) * COALESCE(SUM(ts.sale_amount),0) ) as Commision
                FROM agents a
                left join lonepyinesalelists ts on a.id = ts.agent_id
                left join lonepyines t on t.id = ts.lonepyine_id
                where ts.status = 1
                and t.date = '$current_date'
                and a.referee_id = '$referee->id'
                Group By a.referee_id,a.id;
                ");
                //dd($comission);

                $lppaid_winning = DB::select("SELECT ( t.compensation * SUM(ts.sale_amount) ) totalSale ,re.id, ((a.commision/100)* (COALESCE(SUM(ts.sale_amount),0)) ) as Commission From agents a
                left join referees re on re.id = a.referee_id
                join lonepyinesalelists ts on ts.agent_id = a.id
                join lonepyines t on t.id = ts.lonepyine_id where ts.status = 1 and t.date = '$current_date' and ts.winning_status =1 and a.referee_id = '$referee->id' Group By re.id,t.id;");

                if(count($lppaid_winning) !=0 && count($lpcomission) !=0){
                    $loonpyineprofit = $lonepyine_total - ($lpcomission[0]->Commision + $lppaid_winning[0]->totalSale);
                }else{
                    $loonpyineprofit=0;
                }


            // calculating commision end
            if($tdcomission!=null && $thdcomission != null && $lpcomission != null){
                $refe_totalcommision = $tdcomission[0]->Commision + $thdcomission[0]->Commision + $lpcomission[0]->Commision;
            }
            if($tdcomission!=null && $thdcomission != null && $lpcomission == null){
                $refe_totalcommision = $tdcomission[0]->Commision + $thdcomission[0]->Commision + 0;
            }
            if($tdcomission!=null && $thdcomission == null && $lpcomission != null){
                $refe_totalcommision = $tdcomission[0]->Commision + 0 + $lpcomission[0]->Commision;
            }
            if($tdcomission==null && $thdcomission == null && $lpcomission != null){
                $refe_totalcommision = 0 + $thdcomission[0]->Commision + $lpcomission[0]->Commision;
            }
            else{
                $refe_totalcommision = 0;
            }

            $totalprofit  = $twodprofit+$threedprofit+$loonpyineprofit;


            $referee =Referee::where('user_id',$user->id)->first();
            $refe_twod_salelists = Twodsalelist::select('number', 'sale_amount')->orderBy('sale_amount', 'DESC')->where('twodsalelists.date',$tdy_date)->where('twodsalelists.status',1)
            ->join('agents','twodsalelists.agent_id','agents.id')->where('agents.referee_id',$referee->id)->join('twods', 'twods.id', 'twodsalelists.twod_id')->limit(10)->get();

            $refe_lp_salelists = Lonepyinesalelist::select('number', 'sale_amount')->orderBy('sale_amount', 'DESC')->where('lonepyinesalelists.date',$tdy_date)->where('lonepyinesalelists.status',1)
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
                        return view('dashboard', compact('refe_totalcommision','totalprofit', 'sum', 'agents', 'refe_twod_salelists',
                        'refe_lp_salelists', 'Declined_lonepyineList', 'Declined_twoDList'));
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
