<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\Agent;
use App\Models\Referee;
use Illuminate\Http\Request;
use App\Models\CashinCashout;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CashInRequest;
use App\Http\Requests\CashOutRequest;
use App\Http\Requests\MainCashRequest;
use App\Models\AgentcashHistory;
use App\Models\MaincashHitory;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CashInCashOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function maincashStore(MainCashRequest $request)
    {

        $user = auth()->user();
        $referee = Referee::where('user_id', $user->id)->first();

        $maincash_history = new MaincashHitory();
        $maincash_history->referee_id = $referee->id;
        $maincash_history->main_cash = $request->main_cash;


        if ($referee->main_cash) {
            $referee->main_cash = $referee->main_cash + $request->main_cash;
        } else {
            $referee->main_cash = $request->main_cash;
        }
        $referee->save();
        $maincash_history->save();

        return redirect()->back()->with('main-cash', 'Main Cash added successfully!');
    }

    public function cashInView()
    {
        $user = auth()->user();

        $referee = Referee::where('user_id', $user->id)->first();

        $agents = Agent::where('referee_id', $referee->id)->with('user')->get();
        $cashin_cashouts = CashinCashout::where('referee_id', $referee->id)->with('agent')->get();

        $maincash_histories = MaincashHitory::where('referee_id', $referee->id)->get();

        return view('RefereeManagement.cashin-cashout.cashin', compact('agents', 'cashin_cashouts', 'maincash_histories'));
    }

    public function cashInStore(CashInRequest $request)
    {
        $user = auth()->user();
        $referee = Referee::where('user_id', $user->id)->first();

        $cashin_cashout = CashinCashout::where('agent_id', $request->agent_id)->first();

        if ($cashin_cashout == null) {
            $cin_cout = new CashinCashout();
            $cin_cout->agent_id = $request->agent_id;
            $cin_cout->referee_id = $referee->id;
            $cin_cout->coin_amount = $request->coin_amount ?? 0;
            $cin_cout->status = $request->status;
            if($request->payment > $request->coin_amount) {
                return redirect()->back()->with('error', 'Your payment is greater than the coin amount you wanted!');
            }
            $cin_cout->payment = $request->payment ?? 0;
            $cin_cout->remaining_amount = $request->coin_amount - $request->payment;

            $agent_cash_history = new AgentcashHistory();
            $agent_cash_history->agent_id = $request->agent_id;
            $agent_cash_history->referee_id =  $referee->id;
            $agent_cash_history->agent_cash = $request->coin_amount ?? 0;
            $agent_cash_history->agent_payment = $request->payment ?? 0;
            // $agent_cash_history->agent_withdraw = $request->withdraw ?? 0;

            $agent_cash_history->save();
            $cin_cout->save();
        } else {
            $cashin_cashout->agent_id = $request->agent_id;
            $cashin_cashout->referee_id = $referee->id;
            $cashin_cashout->coin_amount = $cashin_cashout->coin_amount + ($request->coin_amount ?? 0);
            if($request->payment > $request->coin_amount) {
                return redirect()->back()->with('error', 'Your payment is greater than the coin amount you wanted!');
            }
            if (($cashin_cashout->payment + ($request->payment ?? 0)) > $cashin_cashout->coin_amount) {
                $cashin_cashout->status = 1;
            } else {
                $cashin_cashout->status = 2;
            }

            $cashin_cashout->payment = $cashin_cashout->payment + $request->payment;

            if($cashin_cashout->remaining_amount != 0) {
                $cashin_cashout->remaining_amount = $cashin_cashout->coin_amount - $cashin_cashout->payment;
            }else {
                $cashin_cashout->remaining_amount = $request->coin_amount - $request->payment;
            }

            $agent_cash_history = new AgentcashHistory();
            $agent_cash_history->agent_id = $request->agent_id;
            $agent_cash_history->referee_id =  $referee->id;
            $agent_cash_history->agent_cash = $request->coin_amount ?? 0;
            $agent_cash_history->agent_payment = $request->payment ?? 0;
            // $agent_cash_history->agent_withdraw = $request->withdraw ?? 0;

            $agent_cash_history->save();
            $cashin_cashout->save();
        }

        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        // $referee = Referee::where('user_id', $user->id)->first();
        // $agent = Agent::where('referee_id', $referee->id)->get();
        // dd($agent->toArray());
        $cash_amt = CashinCashout::select('coin_amount')->where('cashin_cashouts.agent_id', $request->agent_id)->first();
        $pusher->trigger('channel-agent.' . $request->agent_id, 'App\\Events\\agent_cash',  $cash_amt);
        return redirect()->back()->with('cash-in', 'Cash is added successfully!');
    }

    public function cashInEdit($id)
    {
        $cashin = CashinCashout::findOrFail($id);

        $cashin_agent = CashinCashout::where('agent_id', $cashin->agent_id)->first();

        $agent = Agent::find($cashin_agent->agent_id);
        $usr = User::where('id', $agent->user_id)->first();

        return view('RefereeManagement.cashin-cashout.edit-cashin', compact('cashin', 'usr'));
    }

    public function cashInUpdate($id, Request $request)
    {
        $user = auth()->user();
        $referee = Referee::where('user_id', $user->id)->first();

        $cashin_cashout =  CashinCashout::findOrFail($id);

        if( $request->payment > $cashin_cashout->remaining_amount ) {
            return redirect()->back()->with('error', 'Your payment should not greater than remaining amount you need to pay!');
        }

        if ($cashin_cashout->payment != null || $cashin_cashout->payment != 0) {
            $cashin_cashout->payment = $cashin_cashout->payment + $request->payment;
            $cashin_cashout->remaining_amount = $cashin_cashout->remaining_amount - $request->payment;
        }else {
            $cashin_cashout->payment = $request->payment;
        }

        if($cashin_cashout->payment == $cashin_cashout->coin_amount) {
            $cashin_cashout->remaining_amount = 0;
            $cashin_cashout->status = 1;
        }

        $agent_cash_history = new AgentcashHistory();
        $agent_cash_history->agent_id = $cashin_cashout->agent_id;
        $agent_cash_history->referee_id =  $referee->id;
        $agent_cash_history->agent_payment = $request->payment ?? 0;

        $agent_cash_history->save();
        $cashin_cashout->save();

        return redirect()->route('cashin')->with('cash-in', 'Payment is updated!');
    }

    public function cashOutStore(CashOutRequest $request)
    {
        // dd($request->agent_id);
        $user = auth()->user();
        $referee = Referee::where('user_id', $user->id)->first();
        $cashin_cashout = CashinCashout::where('agent_id', $request->agent_id)->first();

        if($request->withdraw > $cashin_cashout->coin_amount) {
            return redirect()->back()->with('cashout-error', 'You cant withdraw');
        }
        $cashin_cashout->coin_amount = $cashin_cashout->coin_amount - $request->withdraw;
        $cashin_cashout->withdraw = $request->withdraw;

        $agent_cash_history = new AgentcashHistory();
        $agent_cash_history->agent_id = $request->agent_id;
        $agent_cash_history->referee_id =  $referee->id;
        $agent_cash_history->agent_withdraw = $request->withdraw ?? 0;

        $agent_cash_history->save();
        $cashin_cashout->save();

        return redirect()->back()->with('cash-out', 'Successfully cash out!');
    }
}
