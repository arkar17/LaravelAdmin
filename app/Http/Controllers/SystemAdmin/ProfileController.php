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
        $agentsaleamounts= DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount))maincash ,re.id,a.id From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 where re.id= $referee_id Group By a.id;");
        $agents=DB::select("Select a.id,u.name,u.phone
                            From agents a JOIN referees re on re.id = a.referee_id
                            LEFT JOIN users u on u.id = a.user_id
                            where re.id=$referee_id Group By a.id,u.name,u.phone;");

        $twod=Twodsalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','twodsalelists.agent_id')
                    ->where('agents.referee_id',$referee_id)
                    ->where('twodsalelists.status',1)
                    ->groupBy('agents.id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();

        $threed=Threedsalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','threedsalelists.agent_id')
                    ->where('agents.referee_id',$referee_id)
                    ->where('threedsalelists.status',1)
                    ->groupBy('agents.id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();

        $lonepyine=Lonepyinesalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','lonepyinesalelists.agent_id')
                    ->where('agents.referee_id',$referee_id)
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


        return view('system_admin.profile.refereeprofile',compact('referee','agents','results','sum','agentsaleamounts'));
    }

    public function agentprofile($id)
    {
        // $agent=DB::select("Select (COALESCE(SUM(ts.sale_amount),0)) +(COALESCE(SUM(tr.sale_amount),0))+(COALESCE(SUM(ls.sale_amount),0)) maincash,
        //                     a.id,a.image,u.name,u.phone,re.referee_code From agents a
        //                     left JOIN referees re on re.id = a.referee_id
        //                     LEFT join twodsalelists ts on ts.agent_id = a.id AND ts.status=1
        //                     LEFT join threedsalelists tr on tr.agent_id = a.id AND tr.status =1
        //                     LEFT join lonepyinesalelists ls on ls.agent_id = a.id AND ls.status = 1
        //                     LEFT JOIN users u on u.id = a.user_id where a.id=$id Group By a.id,u.name,u.phone,re.referee_code,a.image;");

        $agent=Agent::findOrFail($id);
        $twod=Twodsalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','twodsalelists.agent_id')
                    ->where('agents.id',$id)
                    ->where('twodsalelists.status',1)
                    ->groupBy('agents.referee_id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();

        $threed=Threedsalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                    ->join('agents','agents.id','threedsalelists.agent_id')
                    ->where('agents.id',$id)
                    ->where('threedsalelists.status',1)
                    ->groupBy('agents.referee_id')
                    ->join('users','users.id','agents.user_id')
                    ->get()->toArray();

        $lonepyine=Lonepyinesalelist::select('agents.id','users.name','users.phone','agents.referee_id',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
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

        $twocus=DB::select("Select (SUM(ts.sale_amount))maincash ,a.id,ts.customer_name From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 and a.id=$id Group By a.id,ts.customer_name ORDER BY maincash DESC;");
        $threecus=DB::select("Select (SUM(tr.sale_amount))maincash ,a.id,tr.customer_name From agents a left join referees re on re.id = a.referee_id left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 and a.id=$id Group By a.id,tr.customer_name ORDER BY maincash DESC;");
        $lpcus=DB::select("Select (SUM(ls.sale_amount))maincash ,a.id,ls.customer_name From agents a left join referees re on re.id = a.referee_id left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 and a.id=$id Group By a.id,ls.customer_name ORDER BY maincash DESC;");
        //$cussaleamounts= DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)+SUM(ls.sale_amount))maincash ,a.id,ts.customer_name,tr.customer_name,ls.customer_name From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 WHERE a.id=$id Group By a.id,ts.customer_name,tr.customer_name,ls.customer_name;");
        //$agent=Agent::findOrFail($id);
        $twod_salelists=Twodsalelist::select('agents.id','twodsalelists.customer_name','twodsalelists.customer_phone',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','twodsalelists.agent_id')
                        ->where('agent_id',$id)
                        ->where('status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $threed_salelists=Threedsalelist::select('agents.id','threedsalelists.customer_name','threedsalelists.customer_phone',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','threedsalelists.agent_id')
                        ->where('agent_id',$id)
                        ->where('status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $lonepyine_salelists=Lonepyinesalelist::select('agents.id','lonepyinesalelists.customer_name','lonepyinesalelists.customer_phone',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','lonepyinesalelists.agent_id')
                        ->where('agent_id',$id)
                        ->where('status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $output = array_merge($twod_salelists,$threed_salelists,$lonepyine_salelists);
        $results = array_reduce($output, function($carry, $item){
            if(!isset($carry[$item['customer_name']])){
            $carry[$item['customer_name']] = ['customer_name'=>$item['customer_name'],'customer_name'=>$item['customer_name'],'customer_phone'=>$item['customer_phone'],'Amount'=>$item['Amount']];
            } else {
            $carry[$item['customer_name']]['Amount'] += $item['Amount'];
            }
            return $carry;
            });

        return view('system_admin.profile.agentprofile',compact('agent','sum','results','twod_salelists','threed_salelists','lonepyine_salelists','twocus','threecus','lpcus'));
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
