<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Models\User;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Referee;
use App\Models\Lonepyine;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\Operationstaff;
use App\Models\Threedsalelist;
use App\Models\Lonepyinesalelist;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function refreeprofile($referee_id)
    {
        $referee=Referee::findOrFail($referee_id);
        $agentsaleamounts= DB::select("SELECT (COALESCE(SUM(ts.sale_amount),0)+COALESCE(SUM(tr.sale_amount),0)+COALESCE(SUM(ls.sale_amount),0))maincash ,re.id,a.id,u.name
                                        From agents a left join referees re on re.id = a.referee_id
                                        left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1
                                        left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1
                                        left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1
                                        left join users u on u.id=a.user_id
                                        where re.id= '$referee_id' Group By a.id");

        $agents=DB::select("SELECT a.id,u.name,u.phone
                            From agents a JOIN referees re on re.id = a.referee_id
                            LEFT JOIN users u on u.id = a.user_id
                            where re.id='$referee_id' Group By a.id,u.name,u.phone;");

        $twod_salelist=DB::select("SELECT a.id,u.name,u.phone,SUM(td.sale_amount)-(SUM(td.sale_amount)*(a.commision/100))Amount from agents a
                        left join twodsalelists td on a.id=td.agent_id and td.status=1
                        join referees re on a.referee_id=re.id
                        LEFT JOIN users u on u.id = a.user_id
                        where a.referee_id='$referee_id'
                        group BY a.id;");

         $twod = json_decode(json_encode ( $twod_salelist ) , true);

        $threed_salelist=DB::select("SELECT a.id,u.name,u.phone,SUM(td.sale_amount)-(SUM(td.sale_amount)*(a.commision/100))Amount from agents a
                        left join threedsalelists td on a.id=td.agent_id and td.status=1
                        join referees re on a.referee_id=re.id
                        LEFT JOIN users u on u.id = a.user_id
                        where a.referee_id='$referee_id'
                        group BY a.id;");
        $threed=json_decode(json_encode ( $threed_salelist ) , true);

        $lonepyine_salelists=DB::select("SELECT a.id,u.name,u.phone,SUM(td.sale_amount)-(SUM(td.sale_amount)*(a.commision/100))Amount from agents a
                        left join lonepyinesalelists td on a.id=td.agent_id and td.status=1
                        join referees re on a.referee_id=re.id
                        LEFT JOIN users u on u.id = a.user_id
                        where a.referee_id='$referee_id'
                        group BY a.id;");
        $lonepyine=json_decode(json_encode ( $lonepyine_salelists ) , true);

        //$output = array_merge($two,$three,$lone);
        $res = array_merge($twod,$threed,$lonepyine);
        $sum=0;
            foreach($res as $op){
                $sum+=$op['Amount'];
            }

        $results = array_reduce($res, function($carry, $item){
        if(!isset($carry[$item['id']])){
        $carry[$item['id']] = ['id'=>$item['id'],'name'=>$item['name'],'phone'=>$item['phone'],'Amount'=>$item['Amount']];
        } else {
        $carry[$item['id']]['Amount'] += $item['Amount'];
        }
        return $carry;
        });
        return view('system_admin.profile.refereeprofile',compact('referee','agents','results','sum','agentsaleamounts'));
    }

    public function agentprofile($id)
    {
        $date=Carbon::now()->toDateString();
        $time=Carbon::now()->toTimeString();
        if($time>16){
            $round='Evening';
        }else{
            $round='Morning';
        }
        $agent=Agent::findOrFail($id);

        $twod=Twodsalelist::select('agents.id','users.name','users.phone','agents.referee_id',
        DB::raw('( SUM(twodsalelists.sale_amount ) - ((agents.commision/100) * SUM(twodsalelists.sale_amount) )) As Amount'),
        DB::raw('(((agents.commision/100) * SUM(twodsalelists.sale_amount) )) As Commision')
        )
        ->join('agents','agents.id','twodsalelists.agent_id')
        ->where('agents.id',$id)
        ->where('twodsalelists.status',1)
        ->groupBy('agents.referee_id')
        ->join('users','users.id','agents.user_id')
        ->get()->toArray();

        $threed=Threedsalelist::select('agents.id','users.name','users.phone','agents.referee_id',
                DB::raw('( SUM(threedsalelists.sale_amount ) - ((agents.commision/100) * SUM(threedsalelists.sale_amount) )) As Amount'),
                DB::raw('( ((agents.commision/100) * SUM(threedsalelists.sale_amount) )) As Commision')
                )
                ->join('agents','agents.id','threedsalelists.agent_id')
                ->where('agents.id',$id)
                ->where('threedsalelists.status',1)
                ->groupBy('agents.referee_id')
                ->join('users','users.id','agents.user_id')
                ->get()->toArray();

        $lonepyine=Lonepyinesalelist::select('agents.id','users.name','users.phone','agents.referee_id',
                DB::raw('( SUM(lonepyinesalelists.sale_amount ) - ((agents.commision/100) * SUM(lonepyinesalelists.sale_amount) )) As Amount'),
                DB::raw('(((agents.commision/100) * SUM(lonepyinesalelists.sale_amount) )) As Commision')
                )
                ->join('agents','agents.id','lonepyinesalelists.agent_id')
                ->where('agents.id',$id)
                ->where('lonepyinesalelists.status',1)
                ->groupBy('agents.referee_id')
                ->join('users','users.id','agents.user_id')
                ->get()->toArray();

        $output = array_merge($twod,$threed,$lonepyine);

        $sum=0;
        foreach($output as $op){
            $sum+=$op['Amount'];
        }
        $commisions=0;
        foreach($output as $op){
        $commisions+=$op['Commision'];
        }
        $twocus=DB::select("Select (SUM(ts.sale_amount))maincash ,a.id,ts.customer_name From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 WHERE a.id=$id Group By a.id,ts.customer_name ORDER BY maincash DESC limit 3;");
        $threecus=DB::select("Select (SUM(tr.sale_amount))maincash ,a.id,tr.customer_name From agents a left join referees re on re.id = a.referee_id left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 WHERE a.id=$id Group By a.id,tr.customer_name ORDER BY maincash DESC limit 3;");
        $lpcus=DB::select("Select (SUM(ls.sale_amount))maincash ,a.id,ls.customer_name From agents a left join referees re on re.id = a.referee_id left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 WHERE a.id=$id Group By a.id,ls.customer_name ORDER BY maincash DESC limit 3;");
        //$cussaleamounts= DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount))maincash ,a.id,ts.customer_name,tr.customer_name,ls.customer_name From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 WHERE a.id=$id Group By a.id,ts.customer_name,tr.customer_name,ls.customer_name;");
        //$agent=Agent::findOrFail($id);
        $twod_salelists=Twodsalelist::select('agents.id','twodsalelists.customer_name','twodsalelists.created_at','twodsalelists.customer_phone',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','twodsalelists.agent_id')
                        ->where('agent_id',$id)
                        ->where('status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $threed_salelists=Threedsalelist::select('agents.id','threedsalelists.customer_name','threedsalelists.created_at','threedsalelists.customer_phone',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','threedsalelists.agent_id')
                        ->where('agent_id',$id)
                        ->where('status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $lonepyine_salelists=Lonepyinesalelist::select('agents.id','lonepyinesalelists.customer_name','lonepyinesalelists.created_at','lonepyinesalelists.customer_phone',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','lonepyinesalelists.agent_id')
                        ->where('agent_id',$id)
                        ->where('status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $output = array_merge($twod_salelists,$threed_salelists,$lonepyine_salelists);
        $results = array_reduce($output, function($carry, $item){
            if(!isset($carry[$item['customer_name']])){
            $carry[$item['customer_name']] = ['customer_name'=>$item['customer_name'],'created_at'=>$item['created_at'],'customer_name'=>$item['customer_name'],'customer_phone'=>$item['customer_phone'],'Amount'=>$item['Amount']];
            } else {
            $carry[$item['customer_name']]['Amount'] += $item['Amount'];
            }
            return $carry;
            });

        return view('system_admin.profile.agentprofile',compact('agent','sum','results','twod_salelists','threed_salelists','lonepyine_salelists','twocus','threecus','lpcus','commisions'));
    }

    public function guestprofile($id)
    {
        $guest=User::findOrFail($id);

        return view('system_admin.profile.guestprofile',compact('guest'));
    }

    public function operationstaffprofile($id)
    {

       $operationstaff=Operationstaff::findOrFail($id);
       $referees=Referee::where('operationstaff_id','=',$id)->get();
       return view('system_admin.profile.operationstaffprofile',compact('operationstaff','referees'));

    }
}
