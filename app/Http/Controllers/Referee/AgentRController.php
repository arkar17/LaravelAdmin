<?php

namespace App\Http\Controllers\Referee;

use App\Models\Twod;
use App\Models\User;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\Threedsalelist;
use App\Models\Lonepyinesalelist;
use App\Exports\Export2DSalesList;
use App\Exports\Export3DSalesList;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportlonepyineSalesList;

class AgentRController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function agentData()
    {
        $user = auth()->user()->id;
        $referee = Referee::where('user_id', $user)->first();
        // $agentdata = DB::select("SELECT u.name,u.phone,a.id,COUNT(DISTINCT ts.customer_phone)as NumOfCus FROM agents a left join users u on a.user_id = u.id
        // LEFT JOIN twodsalelists ts on ts.agent_id = a.id Where a.referee_id = $referee->id
        // Group BY ts.agent_id,ts.customer_phone,ts.customer_name;");
        $agentdatatd = Agent::select('users.phone','agents.id','users.name','twodsalelists.customer_name',DB::raw('COUNT(DISTINCT twodsalelists.customer_phone)as NumOfCus'))->join('users','users.id','agents.user_id')->leftJoin('twodsalelists','twodsalelists.agent_id','agents.id')->groupBy('twodsalelists.customer_phone','agents.id')
        ->where('agents.referee_id',$referee->id)->get()->toArray();

        $agentdatathr = Agent::select('users.phone','agents.id','users.name','threedsalelists.customer_name',DB::raw('COUNT(DISTINCT threedsalelists.customer_phone)as NumOfCus'))->join('users','users.id','agents.user_id')->leftJoin('threedsalelists','threedsalelists.agent_id','agents.id')->groupBy('threedsalelists.customer_phone','agents.id')
        ->where('agents.referee_id',$referee->id)->get()->toArray();

        $agentdatalone = Agent::select('users.phone','agents.id','users.name','lonepyinesalelists.customer_name',DB::raw('COUNT(DISTINCT lonepyinesalelists.customer_phone)as NumOfCus'))->join('users','users.id','agents.user_id')->leftJoin('lonepyinesalelists','lonepyinesalelists.agent_id','agents.id')->groupBy('lonepyinesalelists.customer_phone','agents.id')
        ->where('agents.referee_id',$referee->id)->get()->toArray();

        $output = array_merge($agentdatatd,$agentdatathr,$agentdatalone);
        $agentdata = array_reduce($output, function($carry, $item){
            if(!isset($carry[$item['name']])){
            $carry[$item['name']] = ['name'=>$item['name'],'phone'=>$item['phone'],'NumOfCus'=>$item['NumOfCus'],'id'=>$item['id']];
            } else {
            $carry[$item['name']]['NumOfCus'] += $item['NumOfCus'];
            }
            return $carry;
            });

        //dd($agentdata->toArray());
        //dump ($user);
        return view('RefereeManagement.agentdata')->with(['agentdata'=>$agentdata]);

        // return view('data.refereedata',compact('agent'));
    }
    public function agentprofile($id)
    {
        //$agentProfileData = User::select('id','name','phone')->where('id',$id)->get();
        $agentProfileData = Agent::select('agents.id','agents.image','users.name','users.phone')->join('users','users.id','agents.user_id')->where('agents.id',$id)->first();

        // $agentCustomerDatatd = DB::select("Select ts.id, ts.customer_name,
        // ts.customer_phone, t.number, t.compensation, ts.sale_amount from twodsalelists ts left join twods t on ts.twod_id = t.id  where ts.agent_id = $id and ts.status =1;");


        // $agentCustomerDatathd = DB::select("Select ts.id, ts.customer_name,
        // ts.customer_phone, t.number, t.compensation, ts.sale_amount from threedsalelists ts left join threeds t on ts.threed_id = t.id  where ts.agent_id = $id and ts.status =1;");

        // $agentCustomerDatalone = DB::select("Select ts.id, ts.customer_name,
        // ts.customer_phone, t.number, t.compensation, ts.sale_amount from lonepyinesalelists ts left join lonepyines t on ts.lonepyine_id = t.id  where ts.agent_id = $id and ts.status =1;");
        //dd($agentCustomerDatalone);
        $twod_salelists=Twodsalelist::select('agents.id','twods.number','twods.compensation','twodsalelists.customer_name','twodsalelists.customer_phone',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','twodsalelists.agent_id')
                        ->join('twods','twods.id','twodsalelists.twod_id')
                        ->where('twodsalelists.agent_id',$id)
                        ->where('twodsalelists.status',1)
                        ->groupBy('twodsalelists.id')
                        ->get()->toArray();
        //dd($twod_salelists);
        $threed_salelists=Threedsalelist::select('agents.id','threeds.number','threeds.compensation','threedsalelists.customer_name','threedsalelists.customer_phone',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','threedsalelists.agent_id')
                        ->join('threeds','threeds.id','threedsalelists.threed_id')
                        ->where('threedsalelists.agent_id',$id)
                        ->where('threedsalelists.status',1)
                        ->groupBy('threedsalelists.id')
                        ->get()->toArray();

        $lonepyine_salelists=Lonepyinesalelist::select('agents.id','lonepyines.number','lonepyines.compensation','lonepyinesalelists.customer_name','lonepyinesalelists.customer_phone',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','lonepyinesalelists.agent_id')
                        ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
                        ->where('lonepyinesalelists.agent_id',$id)
                        ->where('lonepyinesalelists.status',1)
                        ->groupBy('lonepyinesalelists.id')
                        ->get()->toArray();

        $output = array_merge($twod_salelists,$threed_salelists,$lonepyine_salelists);
        $agentCustomerData = array_reduce($output, function($carry, $item){
            if(!isset($carry[$item['customer_name']])){
            $carry[$item['customer_name']] = ['customer_name'=>$item['customer_name'],'number'=>$item['number'],'compensation'=>$item['compensation'],'customer_phone'=>$item['customer_phone'],'Amount'=>$item['Amount']];
            } else {
            $carry[$item['customer_name']]['Amount'] += $item['Amount'];
            }
            return $carry;
            });


        $commision = Agent::select('commision')->where('id',$id)->first();
        $twodnum = Twod::select('number', 'compensation')->where('referee_id',$id)->get()->toArray();


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


      $twocus=DB::select("Select (SUM(ts.sale_amount))maincash ,a.id,ts.customer_name From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 WHERE a.id=$id Group By a.id,ts.customer_name ORDER BY maincash DESC limit 3;");
      $threecus=DB::select("Select (SUM(tr.sale_amount))maincash ,a.id,tr.customer_name From agents a left join referees re on re.id = a.referee_id left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 WHERE a.id=$id Group By a.id,tr.customer_name ORDER BY maincash DESC limit 3;");
      $lpcus=DB::select("Select (SUM(ls.sale_amount))maincash ,a.id,ls.customer_name From agents a left join referees re on re.id = a.referee_id left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 WHERE a.id=$id Group By a.id,ls.customer_name ORDER BY maincash DESC limit 3;");
      return view('RefereeManagement.agentprofiles')->with(['twocus'=>$twocus,'threecus'=>$threecus,'lpcus'=>$lpcus,'commision'=>$commision,'agentprofiledata'=>$agentProfileData,'agentCustomerData'=>$agentCustomerData, 'sum'=>$sum, 'twodnum'=>$twodnum]);
    }

    public function agentcommsionupdate(Request $request,$id){
        $validated = $request->validate([
            'editagentcomssion' => 'required',
        ]);

        $updateAgentComssion = Agent::findOrFail($id);
       $updateAgentComssion->commision = $request->editagentcomssion;
       $updateAgentComssion->update();
       return redirect()->back()->with(['commisionEditSucess'=>'ကော်မရှင်ပြုပြင်မှု အောင်မြင်သည်']);
    }
    public function export2DList(){
        return Excel::download(new Export2DSalesList, '2d_Sales_list.xlsx');
    }
    public function export3DList(){
        return Excel::download(new Export3DSalesList, '3D_Sales_list.xlsx');
    }
    public function exportlonePyaingList(){
        return Excel::download(new ExportlonepyineSalesList, 'lone_Pyine_list.xlsx');
    }

    public function seedetailcus($customer_phone,$customer_name){
        //$cusname =Twodsalelist::select('customer_name')->where('customer_phone',$customer_phone)->first();
        $twods = Twodsalelist::where('customer_phone',$customer_phone)->where('status',1)->with('twod','agent.user')->get();
        //dd($twods->toArray());
        $threeds = Threedsalelist::where('customer_phone',$customer_phone)->where('status',1)->with('threed','agent.user')->get();
        $lonepyines = Lonepyinesalelist::where('customer_phone',$customer_phone)->where('status',1)->with('lonepyine','agent.user')->get();
        //dd($twod->toArray());
        return view('RefereeManagement.agentcustomerseedetail')->with(['twods'=>$twods,'threeds'=>$threeds,'lonepyines'=>$lonepyines,'cusname'=>$customer_name]);
    }


}
