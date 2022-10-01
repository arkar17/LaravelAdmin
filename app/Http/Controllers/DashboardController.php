<?php

namespace App\Http\Controllers;

use PDF;
use Throwable;
use Carbon\Carbon;
use App\Models\Twod;
use App\Models\User;
use App\Models\Agent;
use App\Models\Threed;
use App\Models\Referee;
use App\Models\Lonepyine;
use App\Events\twodbetlist;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use App\Models\WinningNumber;
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

    public function viewWinning(Request $request)
    {
        $current_day=Carbon::now()->format('d');
        $current_month_days=Carbon::now()->daysInMonth;

        if($current_day == 16){
            if($current_month_days == 30){
                $threed_date=Carbon::now()->subDays(14)->toDateString();
            }elseif($current_month_days == 31){
                $threed_date=Carbon::now()->subDays(15)->toDateString();
            }
        }elseif($current_day == 1){
            $threed_date=Carbon::now()->subDays(15)->toDateString();
        }else{
            return redirect()->back()->with('success', '3D winning number can only add on 1 and 16 day of a month');
        }

        $date = Carbon::Now()->toDateString();
        $time = Carbon::now()->toTimeString();
        if($time > 16){
            $round = "Evening";
            }
            else{
            $round = "Morning";
            }
        $twodnumbers=DB::select("SELECT u.name,two.round,two.number,two.date,ts.id,ts.customer_name,ts.customer_phone
                                From agents a left join twodsalelists ts on ts.agent_id = a.id
                                LEFT join twods two on two.id=ts.twod_id
                                LEFT join users u on u.id=a.user_id where ts.winning_status = 1
                                and two.date='$date' and two.round='$round';");

        $lonepyinenumbers=DB::select("SELECT u.name,l.round,l.number,lps.id,l.date,lps.customer_name,lps.customer_phone From agents a left join lonepyinesalelists lps on lps.agent_id = a.id LEFT join lonepyines l on l.id=lps.lonepyine_id LEFT join users u on u.id=a.user_id where
        lps.winning_status = 1 and l.date='$date' and l.round='$round';");

        $threednumbers=DB::select("SELECT u.name,t.number,ts.id,t.date,ts.customer_name,ts.customer_phone
                                    From agents a left join threedsalelists ts on ts.agent_id = a.id
                                    LEFT join threeds t on t.id=ts.threed_id
                                    LEFT join users u on u.id=a.user_id
                                    WHERE t.date BETWEEN '$threed_date' AND '$date'  AND ts.winning_status = 1;");
                                    //dd($threednumbers);
        return view('system_admin.winning_result', compact('twodnumbers','threednumbers','lonepyinenumbers'))->with('success', 'Winning Status is Updated successfully!');

    }

    public function winningstatus(Request $request)
    {
        $date = Carbon::Now()->toDateString();
        $user=auth()->user()->id;
        $time = Carbon::now()->toTimeString();
        $winningnumber=new WinningNumber();
        $winningnumber->user_id= $user;
        $winningnumber->number=$request->number;
        $winningnumber->type=$request->type;
        $winningnumber->date=Carbon::now();
        $current_date=Carbon::now()->toDateString();

        if($time > 16){
        $round = "Evening";
        }
        else{
        $round = "Morning";
        }
        $winningnumber->round=$round;

        $winningnumber->save();

        if($request->type=='2d'){
            $twodnum=Twod::where('number','=',$request->number)->first();
            if(!empty($twodnum->id)){
                $twodnum=DB::table('twods')
                            ->join('twodsalelists','twodsalelists.twod_id','=','twods.id')
                            ->where('twods.number',$request->number)
                            ->where('twods.round',$round)
                            ->where('twods.date',$current_date)
                            ->where('twodsalelists.status',1)->update(['twodsalelists.winning_status'=>1]);
                $lonepyineno=substr($request->number, 0, 1);
                $lonepyinelno=$request->number % 10;

                $lonepyineno = DB::table('lonepyines')->where('number','LIKE',$lonepyineno.'%')
                                ->join('lonepyinesalelists','lonepyinesalelists.lonepyine_id','=','lonepyines.id')
                                ->where('lonepyinesalelists.status','=','1')
                                ->where('lonepyines.round',$round)
                                ->where('lonepyines.date',$current_date)
                                ->update(['lonepyinesalelists.winning_status'=>1]);

                $lonepyinelno = DB::table('lonepyines')->where('number','LIKE','%'.$lonepyinelno)
                                ->join('lonepyinesalelists','lonepyinesalelists.lonepyine_id','=','lonepyines.id')
                                ->where('lonepyinesalelists.status','=','1')
                                ->where('lonepyines.round',$round)
                                ->where('lonepyines.date',$current_date)
                                ->update(['lonepyinesalelists.winning_status'=>1]);
            }else{
                return redirect()->back()->with('success', 'Not a Winning Number');
            }
        }elseif($request->type=='3d'){
            $current_day=Carbon::now()->format('d');
            $current_month_days=Carbon::now()->daysInMonth;

            if($current_day == 16){
                if($current_month_days == 30){
                    $threed_date=Carbon::now()->subDays(14);
                }elseif($current_month_days == 31){
                    $threed_date=Carbon::now()->subDays(15);
                }
            }elseif($current_day == 1){
                $threed_date=Carbon::now()->subDays(15);
            }else{
                return redirect()->back()->with('success', '3D winning number can only add on 1 and 16 day of a month');
            }
            $threednum=Threed::where('number','=',$request->number)->first();
            if(!empty($threednum->id)){
                $threednum=Threed::where('number','=',$request->number)
                ->join('threedsalelists','threedsalelists.threed_id','=','threeds.id')
                ->where('threedsalelists.status','=','1')
                ->whereBetween('threeds.date', [$threed_date, $current_date])
                ->update(['threedsalelists.winning_status'=>1]);
            }else{
                return redirect()->back()->with('success', 'Not a Winning Number');
            }
        }elseif($request->type==''){
            return redirect()->back()->with('success', 'Choose Type!');
        }

        $twodOutput=DB::select("Select ( COALESCE(two.compensation,0)  * COALESCE(SUM(ts.sale_amount),0) ) as cash,two.compensation,re.id,two.number From referees re
                                join agents a on re.id = a.referee_id
                                left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 and ts.winning_status=1
                                left join twods two on two.id=ts.twod_id and two.round='$round' and two.date='$date'
                                Group By re.id,two.id;");

        $threedOutput=DB::select("Select ( COALESCE(two.compensation,0)  * COALESCE(SUM(ts.sale_amount),0)) as cash,two.compensation,re.id,two.number From referees re
                                join agents a on re.id = a.referee_id
                                left join threedsalelists ts on ts.agent_id = a.id and ts.status = 1 and ts.winning_status=1
                                left join threeds two on two.id=ts.threed_id and two.date='$date'
                                Group By re.id,two.id");

        $lonepyineOutput=DB::select("Select ( COALESCE(two.compensation,0)  * COALESCE(SUM(ts.sale_amount),0) )as cash,two.compensation,re.id,two.number From referees re
                                join agents a on re.id = a.referee_id
                                left join lonepyinesalelists ts on ts.agent_id = a.id and ts.status = 1 and ts.winning_status=1
                                left join lonepyines two on two.id=ts.lonepyine_id and two.round='$round' and two.date='$date'
                                Group By re.id,two.id");


        foreach($twodOutput as $re){
            $cash=(int)$re->cash;
            $maincash=DB::table('referees')
                        ->where('id',$re->id)
                        ->select('main_cash')->first();
            $reCash= $maincash->main_cash-$cash;
            $referee=DB::table('referees')
            ->where('id',$re->id)
            ->update(array(
                'main_cash'=> $reCash
              ));
        }
        foreach($threedOutput as $re){
            $cash=(int)$re->cash;
            $maincash=DB::table('referees')
                        ->where('id',$re->id)
                        ->select('main_cash')->first();
            $reCash= $maincash->main_cash-$cash;
            DB::table('referees')
            ->where('id',$re->id)
            ->update(array(
                'main_cash'=> $reCash
              ));
        }
        foreach($lonepyineOutput as $re){
            $cash=(int)$re->cash;
            $maincash=DB::table('referees')
                        ->where('id',$re->id)
                        ->select('main_cash')->first();
            $reCash= $maincash->main_cash-$cash;
            DB::table('referees')
            ->where('id',$re->id)
            ->update(array(
                'main_cash'=> $reCash
              ));
        }

        $twod=DB::select("Select t.compensation,( COALESCE(t.compensation,0) * COALESCE(SUM(ts.sale_amount),0) ) as sales ,a.id  from agents a join twodsalelists ts
                        on a.id = ts.agent_id and ts.status = 1 and ts.winning_status = 1
                        left join twods t on t.id = ts.twod_id and t.date = '$date' and t.round = '$round'
                        GROUP by a.id,t.id");

        $threed = DB::select("Select t.compensation,( COALESCE(t.compensation,0) * COALESCE(SUM(ts.sale_amount),0) ) as sales ,a.id  from agents a join threedsalelists ts
                        on a.id = ts.agent_id and ts.status = 1 and ts.winning_status = 1
                        left join threeds t on t.id = ts.threed_id and t.date = '$date'
                        GROUP by a.id,t.id");


        $lonePyaing = DB::select("Select t.compensation,( COALESCE(t.compensation,0) * COALESCE(SUM(ts.sale_amount),0) ) as sales ,a.id  from agents a join lonepyinesalelists ts
                        on a.id = ts.agent_id and ts.status = 1 and ts.winning_status = 1
                        left join lonepyines t on t.id = ts.lonepyine_id and t.date = '$date' and t.round = '$round'
                        GROUP by a.id,t.id");

        foreach($twod as $value){

            $maincash=DB::table('cashin_cashouts')
            ->where('agent_id',$value->id)
            ->select('coin_amount')->first();
            if($maincash != null){
                $amount=$value->sales;
                $coin = $maincash->coin_amount + $amount;
            }
            else{
                $amount=$value->sales;
                $coin = 0 + $amount;
            }



            CashinCashout::where('agent_id',$value->id)->update(['coin_amount'=>$coin]);
        }
        foreach($lonePyaing as $value){

            $maincash=DB::table('cashin_cashouts')
            ->where('agent_id',$value->id)
            ->select('coin_amount')->first();

            if($maincash != null){
                $amount=$value->sales;
                $coin = $maincash->coin_amount + $amount;
            }
            else{
                $amount=$value->sales;
                $coin = 0 + $amount;
            }

            CashinCashout::where('agent_id',$value->id)->update(['coin_amount'=>$coin]);
        }
        foreach($threed as $value){

            $maincash=DB::table('cashin_cashouts')
            ->where('agent_id',$value->id)
            ->select('coin_amount')->first();

            if($maincash != null){
                $amount=$value->sales;
                $coin = $maincash->coin_amount + $amount;
            }
            else{
                $amount=$value->sales;
                $coin = 0 + $amount;
            }

            CashinCashout::where('agent_id',$value->id)->update(['coin_amount'=>$coin]);
        }

        return redirect ()->back()->with('success', 'Winning Status is Updated successfully!');
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

                $twod_salelists = Twodsalelist::select('twods.number', DB::raw('SUM(twodsalelists.sale_amount)sale_amount'))
                                                ->orderBy('sale_amount', 'DESC')
                                                ->join('twods', 'twods.id', 'twodsalelists.twod_id')
                                                ->where('twods.date',$tdy_date)
                                                ->where('twods.round',$round)
                                                ->groupBy('twods.number')
                                                ->limit(10)->get();
                $lp_salelists = Lonepyinesalelist::select('lonepyines.number', DB::raw('SUM(lonepyinesalelists.sale_amount)sale_amount'))
                                                ->orderBy('sale_amount', 'DESC')
                                                ->join('lonepyines', 'lonepyines.id', 'lonepyinesalelists.lonepyine_id')
                                                ->where('lonepyines.date',$tdy_date)
                                                ->where('lonepyines.round',$round)
                                                ->groupBy('lonepyines.number')
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

            // $twodtotal = (int)Twodsalelist::Select('twods.referee_id',DB::raw('SUM(twodsalelists.sale_amount)as sales'))
            // ->join('twods','twods.id','twodsalelists.twod_id')
            // ->where('twodsalelists.status', '=', '1')->gorupBy('twods.referee_id')->get();
            $twodtotal =  Twodsalelist::select('twods.referee_id',DB::raw('sum(twodsalelists.sale_amount) as Amount'))
                ->join('twods','twods.id','twodsalelists.twod_id')
                ->where('twods.date',$current_date)
                ->where('twods.referee_id',$referee->id)
                ->where('twodsalelists.status',1)
                ->groupBy('twods.referee_id')
                ->get()->toArray();
                // dd($twodtotal);
            $lonepyinetotal =  Lonepyinesalelist::select('lonepyines.referee_id',DB::raw('sum(lonepyinesalelists.sale_amount) as Amount'))
                ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
                ->where('lonepyines.date',$current_date)
                ->where('lonepyines.referee_id',$referee->id)
                ->where('lonepyinesalelists.status',1)
                ->groupBy('lonepyines.referee_id')
                ->get()->toArray();

            $threedtotal =  Threedsalelist::select('threeds.referee_id',DB::raw('sum(threedsalelists.sale_amount)as Amount'))
                ->join('threeds','threeds.id','threedsalelists.threed_id')
                ->where('threeds.date',$current_date)
                ->where('threeds.referee_id',$referee->id)
                ->where('threedsalelists.status',1)
                ->groupBy('threeds.referee_id')
                ->get()->toArray();

            $output = array_merge($twodtotal,$lonepyinetotal,$threedtotal);


            // dd($output);

            // if(!$twodtotal){
            //     $output = array_merge($lonepyinetotal,$threedtotal);
            // }
            // if(!$lonepyinetotal){
            //     $output = array_merge($twodtotal,$threedtotal);
            // }
            // if(!$threedtotal){
            //     $output = array_merge($twodtotal,$lonepyinetotal);
            // }
            // else{
            //     $output = array_merge($twodtotal,$lonepyinetotal,$threedtotal);
            // }

            //  dd($output);

            $sum = array_reduce($output, function($carry, $item){
                if(!isset($carry[$item['referee_id']])){
                $carry[$item['referee_id']] = ['Amount'=>$item['Amount']];
                } else {
                $carry[$item['referee_id']]['Amount'] += $item['Amount'];
                }
                return $carry;
                });
                // dd($sum);
            // $sum = $twod_total+$threed_total+$lonepyine_total;
            // calculating commision start

            //twod commision
                $tdcomission = DB::select("SELECT SUM(ts.sale_amount), a.commision ,a.referee_id, ((a.commision/100) * SUM(ts.sale_amount) ) as Commision
                FROM agents a
                left join twodsalelists ts on a.id = ts.agent_id
                left join twods t on t.id = ts.twod_id
                where ts.status = 1
                and t.date = '$current_date'
                and a.referee_id = '$referee->id'
                Group By a.referee_id,a.id;
                ");
    //dd($tdcomission[0]->Commision);

                //twod yaw kyay
                $tdpaid_winning = DB::select("SELECT ( t.compensation * SUM(ts.sale_amount) ) totalSale ,re.id, ((a.commision/100)* SUM(ts.sale_amount)) as Commission From agents a
                left join referees re on re.id = a.referee_id
                join twodsalelists ts on ts.agent_id = a.id
                join twods t on t.id = ts.twod_id where ts.status = 1 and t.date = '$current_date' and ts.winning_status =1 and a.referee_id = '$referee->id' Group By re.id,t.id;");
                //dd($tdpaid_winning);
                if(count($tdpaid_winning) !=0 && count($tdcomission) !=0){
                    $twodprofit = $twod_total - ($tdcomission[0]->Commision + $tdpaid_winning[0]->totalSale);
                }else{
                    $twodprofit=0;
                }

                //threed commision
                $thdcomission = DB::select("SELECT SUM(ts.sale_amount), a.commision ,a.referee_id, (  (a.commision/100) * SUM(ts.sale_amount) ) as Commision
                FROM agents a
                left join threedsalelists ts on a.id = ts.agent_id
                left join threeds t on t.id = ts.threed_id
                where ts.status = 1
                and t.date = '$current_date'
                and a.referee_id = '$referee->id'
                Group By a.referee_id,a.id;
                ");
                //dd($thdcomission[0]->Commision);

                $thdpaid_winning = DB::select("SELECT ( t.compensation * SUM(ts.sale_amount) ) totalSale ,re.id, ((a.commision/100)* SUM(ts.sale_amount)) as Commission From agents a
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
                $lpcomission = DB::select("SELECT SUM(ts.sale_amount), a.commision ,a.referee_id, (  (a.commision/100) * SUM(ts.sale_amount) ) as Commision
                FROM agents a
                left join lonepyinesalelists ts on a.id = ts.agent_id
                left join lonepyines t on t.id = ts.lonepyine_id
                where ts.status = 1
                and t.date = '$current_date'
                and a.referee_id = '$referee->id'
                Group By a.referee_id,a.id;
                ");
                //dd($comission);

                $lppaid_winning = DB::select("SELECT ( t.compensation * SUM(ts.sale_amount) ) totalSale ,re.id, ((a.commision/100)* SUM(ts.sale_amount))  as Commission From agents a
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
            else if($tdcomission!=null && $thdcomission != null && $lpcomission == null){
                $refe_totalcommision = $tdcomission[0]->Commision + $thdcomission[0]->Commision + 0;
            }
            else if($tdcomission!=null && $thdcomission == null && $lpcomission != null){
                $refe_totalcommision = $tdcomission[0]->Commision + 0 + $lpcomission[0]->Commision;
            }
            else if($tdcomission==null && $thdcomission != null && $lpcomission != null){
                $refe_totalcommision = 0 + $thdcomission[0]->Commision + $lpcomission[0]->Commision;
            }
            else{
                $refe_totalcommision = 0;
            }

            $totalprofit  = $twodprofit+$threedprofit+$loonpyineprofit;


            $referee =Referee::where('user_id',$user->id)->first();
            $refe_twod_salelists = Twodsalelist::select('twods.number',DB::raw('SUM(twodsalelists.sale_amount)sale_amount'))->where('twods.date',$tdy_date)->where('twodsalelists.status',1)->join('agents','twodsalelists.agent_id','agents.id')->where('agents.referee_id',$referee->id)
            ->join('twods', 'twods.id', 'twodsalelists.twod_id')->where('twods.round',$round)
            ->groupBy('twods.number')->orderBy('sale_amount', 'DESC')->limit(10)->get();

            $refe_lp_salelists = Lonepyinesalelist::select('lonepyines.number', DB::raw('SUM(lonepyinesalelists.sale_amount)sale_amount'))->where('lonepyines.date',$tdy_date)->where('lonepyinesalelists.status',1)->where('lonepyines.round',$round)
            ->join('agents','lonepyinesalelists.agent_id','agents.id')->where('agents.referee_id',$referee->id)
            ->join('lonepyines', 'lonepyines.id', 'lonepyinesalelists.lonepyine_id')->groupBy('lonepyines.number')->orderBy('sale_amount', 'DESC')->limit(10)->get();

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
