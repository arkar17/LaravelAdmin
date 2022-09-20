<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Referee;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CashInRequest;
use Illuminate\Support\Facades\Validator;

class CashInCashOutController extends Controller
{

    public function maincashStore(Request $request)
    {

        $user = auth()->user();
        $referee = Referee::where('user_id', $user->id)->first();

        if($referee->main_cash) {
            $referee->main_cash = $referee->main_cash + $request->main_cash;
        }else {
            $referee->main_cash = $request->main_cash;
        }
        $referee->save();

        return redirect()->back()->with('main-cash', 'Main Cash added successfully!');
    }

    public function cashInView()
    {
        $user = auth()->user();

        $referee = Referee::where('user_id', $user->id)->first();

        $agents = Agent::where('referee_id', $referee->id)->with('user')->get();
        $cashin_cashouts = CashinCashout::where('referee_id', $referee->id)->with('agent')->get();

        return view('RefereeManagement.cashin-cashout.cashin', compact('agents','cashin_cashouts'));
    }

    public function cashInStore(CashInRequest $request)
    {
        $user = auth()->user();
        $referee = Referee::where('user_id', $user->id)->first();


        $cashin_cashout = CashinCashout::where('agent_id', $request->agent_id)->first();
        // dd($cashin_cashout);

        if($cashin_cashout == null) {
            $cin_cout = new CashinCashout();
            $cin_cout->agent_id = $request->agent_id;
            $cin_cout->referee_id = $referee->id;
            $cin_cout->coin_amount = $request->coin_amount ?? 0;
            $cin_cout->status = $request->status;
            $cin_cout->payment = $request->payment;
            $cin_cout->save();
        }else {
            $cashin_cashout->agent_id = $request->agent_id;
            $cashin_cashout->referee_id = $referee->id;
            $cashin_cashout->coin_amount = $cashin_cashout->coin_amount + ($request->coin_amount ?? 0);
            if($cashin_cashout->coin_amount > ($cashin_cashout->payment + $request->payment)) {
                $cashin_cashout->status = 2;
            }else {
                $cashin_cashout->status = 1;
            }

            $cashin_cashout->payment = $cashin_cashout->payment + $request->payment;
            $cashin_cashout->save();
        }



        return redirect()->back()->with('cash-in', 'Cash is added successfully!');
    }

    public function cashOutStore(Request $request)
    {
        // dd($request->agent_id);
        $cashin_cashout = CashinCashout::where('agent_id', $request->agent_id)->first();

        $cashin_cashout->coin_amount = $cashin_cashout->coin_amount - $request->withdraw;
        $cashin_cashout->withdraw = $request->withdraw;
        $cashin_cashout->save();

        return redirect()->back()->with('cash-out', 'Successfully cash out!');
    }
}
