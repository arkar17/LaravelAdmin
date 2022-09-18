<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agent;
use App\Models\Twod;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function agentprofile($id)
    {
        $agentProfileData = User::select('users.id','users.name','users.phone','agents.image')->join('agents','agents.user_id','users.agent_id')->where('id',$id)->first();
        $agentCustomerData = Twodsalelist::select('twodsalelists.id','twodsalelists.customer_name','twodsalelists.customer_phone','twodsalelists.agent_id','twodsalelists.sale_amount','twodsalelists.twod_id')
                                ->where('twodsalelists.agent_id',$id)
                                ->join('twods','twods.id','twodsalelists.twod_id')
                                ->get();
        $commision = Agent::select('commision')->where('id',$id)->first();
        $twodnum = Twod::select('number', 'compensation')->where('referee_id',$id)->get()->toArray();

        $totalAmount = Twodsalelist::select('twodsalelists.sale_amount')->where('twodsalelists.agent_id',$id)->get()->toArray();

        $total=0;
        for($i=0; $i<count($totalAmount); $i++){
          $total+=implode(" ",$totalAmount[$i]);
        }
        return view('RefereeManagement.agentprofiles')->with(['commision'=>$commision,'agentprofiledata'=>$agentProfileData, 'agentcustomerdata'=>$agentCustomerData, 'totalamount'=>$total, 'twodnum'=>$twodnum]);
    }

    public function agentcommsionupdate(Request $request,$id){
        $updateAgentComssion = Agent::findOrFail($id);
       $updateAgentComssion->comssion = $request->editagentcomssion;
       $updateAgentComssion->update();
       return redirect()->back()->with(['commision'=>'Commision Edit Success']);
    }
    // public function refreeprofile($id)
    // {
    //     $referee=Client::findOrFail($id);
    //     return view('profile.refereeprofile',compact('referee'));
    // }

    public function agentcontroller()
    {
        return view('profile.agentprofile');
    }
}
