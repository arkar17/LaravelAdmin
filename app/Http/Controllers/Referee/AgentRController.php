<?php

namespace App\Http\Controllers\Referee;

use App\Models\Twod;
use App\Models\User;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
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
        $agentdata = DB::select("SELECT a.id,u.name,u.phone ,Count(td.customer_name) as NumOfCus FROM agents a left join users u on a.user_id = u.id left join twodsalelists td on a.id = td.agent_id where a.referee_id = '$referee->id' Group By td.agent_id,u.name,u.phone,a.id");
        //dd($agentdata);
        // dump ($user);
        return view('RefereeManagement.agentdata')->with(['agentdata'=>$agentdata]);

        // return view('data.refereedata',compact('agent'));
    }
    public function agentprofile($id)
    {
        //$agentProfileData = User::select('id','name','phone')->where('id',$id)->get();
        $agentProfileData = Agent::select('agents.id','agents.image','users.name','users.phone')->join('users','users.id','agents.user_id')->where('agents.id',$id)->first();
        //dd($agentProfileData);
        $agentCustomerData = DB::select("Select ts.id, ts.customer_name,
        ts.customer_phone, t.number, t.compensation, ts.sale_amount from twodsalelists ts left join twods t on ts.twod_id = t.id where ts.agent_id = $id");
        $commision = Agent::select('commision')->where('id',$id)->first();
        $twodnum = Twod::select('number', 'compensation')->where('referee_id',$id)->get()->toArray();

        $totalAmount = Twodsalelist::select('twodsalelists.sale_amount')->where('twodsalelists.agent_id',$id)->get()->toArray();

        $total=0;
        for($i=0; $i<count($totalAmount); $i++){
          $total+=implode(" ",$totalAmount[$i]);
        }

      $twocus=DB::select("Select (SUM(ts.sale_amount))maincash ,a.id,ts.customer_name From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 WHERE a.id=$id Group By a.id,ts.customer_name ORDER BY maincash DESC limit 3;");
      $threecus=DB::select("Select (SUM(tr.sale_amount))maincash ,a.id,tr.customer_name From agents a left join referees re on re.id = a.referee_id left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 WHERE a.id=$id Group By a.id,tr.customer_name ORDER BY maincash DESC limit 3;");
      $lpcus=DB::select("Select (SUM(ls.sale_amount))maincash ,a.id,ls.customer_name From agents a left join referees re on re.id = a.referee_id left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 WHERE a.id=$id Group By a.id,ls.customer_name ORDER BY maincash DESC limit 3;");
      return view('RefereeManagement.agentprofiles')->with(['twocus'=>$twocus,'threecus'=>$threecus,'lpcus'=>$lpcus,'commision'=>$commision,'agentprofiledata'=>$agentProfileData, 'agentcustomerdata'=>$agentCustomerData, 'totalamount'=>$total, 'twodnum'=>$twodnum]);
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

}
