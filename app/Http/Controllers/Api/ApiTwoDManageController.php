<?php

namespace App\Http\Controllers\Api;

use auth;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\twod;
use App\Models\Agent;
use App\Models\Referee;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class ApiTwoDManageController extends Controller
{
    //
    public function getTwoDs(){
        $user = auth()->user();
        $currenDate = Carbon::now()->toDateString();
        $time = Carbon::Now()->toTimeString();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->with('referee')->first();
            $referee = Referee::where('user_id', $agent->referee->user_id)->with('user')->first();
            if($time > 12){
            $twoD_sale_lists = DB::select("Select aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM ( SELECT * FROM twods t where client_id = '$referee->id' ORDER BY id DESC LIMIT 100 )sub ORDER BY id ASC) aa
            LEFT join agents on aa.client_id = agents.id
            LEFT join twod_sales_lists ts on ts.twod_id = aa.id
            where aa.client_id = '$referee->id'
            and aa.date = '$currenDate'
            and aa.round = 'Evening'
            group by aa.number, aa.max_amount , agents.id , aa.max_amount , aa.compensation");
        }
        else{
            $twoD_sale_lists = DB::select("Select aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
            from (SELECT * FROM ( SELECT * FROM twods t where client_id = '$referee->id' ORDER BY id DESC LIMIT 100 )sub ORDER BY id ASC) aa
            LEFT join agents on aa.client_id = agents.id
            LEFT join twod_sales_lists ts on ts.twod_id = aa.id
            where aa.client_id = '$referee->id'
            and aa.date = '$currenDate'
            and aa.round = 'Morning'
            group by aa.number, aa.max_amount , agents.id , aa.max_amount , aa.compensation");
        }
    }
        return response()->json([
            'status' => 200,
            'data' => ['salesList' => $twoD_sale_lists]
        ]);



    }
}

