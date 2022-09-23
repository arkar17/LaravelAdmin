<?php

namespace App\Http\Controllers\SystemAdmin;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Twod;
use App\Models\User;
use App\Models\Guest;
use App\Models\Client;
use App\Models\Threed;
use App\Models\Referee;
use App\Models\Lonepyine;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use App\Models\WinningNumber;
use App\Models\Threedsalelist;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function lang($locale){
        App::setLocale($locale);
        Session::put("locale",$locale);
        return redirect()->back();
    }



    public function index()
    {
        $users=User::where('status','=','0')->get();
        return view('system_admin.home',compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect ()->back()->with('success', 'User is deleted successfully!');
    }

    public function viewWinning(Request $request)
    {
        $twodnumbers=DB::select('Select u.name,two.round,two.number,two.date,ts.id,ts.customer_name,ts.customer_phone,ts.datetime From agents a left join twodsalelists ts on ts.agent_id = a.id LEFT join twods two on two.id=ts.twod_id LEFT join users u on u.id=a.user_id where ts.winning_status = 1 and two.date=CURRENT_DATE;');
        $lonepyinenumbers=DB::select('Select u.name,l.round,l.number,lps.id,l.date,lps.customer_name,lps.customer_phone,lps.datetime From agents a left join lonepyinesalelists lps on lps.agent_id = a.id LEFT join lonepyines l on l.id=lps.lonepyine_id LEFT join users u on u.id=a.user_id where lps.winning_status = 1 and l.date=CURRENT_DATE;');
        $threednumbers=DB::select('Select u.name,t.number,ts.id,t.date,ts.customer_name,ts.customer_phone,ts.datetime From agents a left join threedsalelists ts on ts.agent_id = a.id LEFT join threeds t on t.id=ts.threed_id LEFT join users u on u.id=a.user_id where ts.winning_status = 1 and t.date=CURRENT_DATE;');
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
                            ->where('date',$current_date)
                            ->where('twodsalelists.status','1')->update(['twodsalelists.winning_status'=>1]);
                $lonepyineno=substr($request->number, 0, 1);
                $lonepyinelno=$request->number % 10;

                $lonepyineno = DB::table('lonepyines')->where('number','LIKE',$lonepyineno.'%')
                                ->join('lonepyinesalelists','lonepyinesalelists.lonepyine_id','=','lonepyines.id')
                                ->where('lonepyinesalelists.status','=','1')
                                ->where('lonepyines.round',$round)
                                ->where('date',$current_date)
                                ->update(['lonepyinesalelists.winning_status'=>1]);

                $lonepyinelno = DB::table('lonepyines')->where('number','LIKE','%'.$lonepyinelno)
                                ->join('lonepyinesalelists','lonepyinesalelists.lonepyine_id','=','lonepyines.id')
                                ->where('lonepyinesalelists.status','=','1')
                                ->where('lonepyines.round',$round)
                                ->where('date',$current_date)
                                ->update(['lonepyinesalelists.winning_status'=>1]);
            }else{
                return redirect()->back()->with('success', 'Not a Winning Number');
            }
        }elseif($request->type=='3d'){
            $threednum=Threed::where('number','=',$request->number)->first();
            if(!empty($threednum->id)){
                $threednum=Threed::where('number','=',$request->number)
                ->join('threedsalelists','threedsalelists.threed_id','=','threeds.id')
                ->where('threedsalelists.status','=','1')
                ->where('date',$current_date)
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

            $amount=$value->sales;
            $coin = $maincash->coin_amount + $amount;

            CashinCashout::where('agent_id',$value->id)->update(['coin_amount'=>$coin]);
        }
        foreach($lonePyaing as $value){

            $maincash=DB::table('cashin_cashouts')
            ->where('agent_id',$value->id)
            ->select('coin_amount')->first();

            $amount=$value->sales;
            $coin = $maincash->coin_amount + $amount;

            CashinCashout::where('agent_id',$value->id)->update(['coin_amount'=>$coin]);
        }
        foreach($threed as $value){

            $maincash=DB::table('cashin_cashouts')
            ->where('agent_id',$value->id)
            ->select('coin_amount')->first();

            $amount=$value->sales;
            $coin = $maincash->coin_amount + $amount;

            CashinCashout::where('agent_id',$value->id)->update(['coin_amount'=>$coin]);
        }

        return redirect ()->back()->with('success', 'Winning Status is Updated successfully!');
    }

    public function adminprofile()
    {
        return view('system_admin.profile.adminprofile');
    }
}
