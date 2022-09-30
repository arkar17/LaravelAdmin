<?php

namespace App\Http\Controllers\Api\WinningResult;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lonepyinesalelist;
use App\Models\Threedsalelist;
use App\Models\WinningNumber;

class WinningResultController extends Controller
{
    // public function checkResult()
    // {

    //     $twod_salelists = TwodSalelist::where('status', 1)->with('twod')->get();


    //     // return $twod_salelists;

    //     // $twod_salelists->twod->number;
    //     // foreach ($twod_salelists as $twod_salelist) {
    //     //     echo $twod_salelist->twod->number . " ";
    //     // }

    //     $file_path = public_path() . '/winning_result/result.json';
    //     $raw_data = file_get_contents($file_path);
    //     $json_data =  json_decode($raw_data);

    //     $result_time = Carbon::now('Asia/Yangon')->toTimeString();

    //     foreach ($json_data->result as $result) {
    //         if ($result->open_time == '12:01:00') {
    //             // return "----------HI ---------------";
    //             //return $result->twod;
    //             foreach ($twod_salelists as $twod_salelist) {
    //                if($twod_salelist->twod->number == $result->twod) {
    //                     $twod_salelist = TwodSalelist::findOrFail($twod_salelist->id);
    //                     $twod_salelist->winning_status = 1;
    //                     $twod_salelist->update();

    //                     // return response()->json()
    //                     echo $twod_salelist->id . "<br>";
    //                     echo "Your number is  " . $twod_salelist->twod->number . ' and Winning resut is ' . $result->twod . "/";
    //                }else {
    //                 echo "Ma Nyi bar  ";
    //                }
    //             }
    //         }
    //     }
    // }

    public function twodWin() {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();
            $twod_win = Twodsalelist::where('winning_status', 1)
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'data' => $twod_win
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function twodWinByDate(Request $request) {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date =  $request->current_date;
            $twod_win = Twodsalelist::where('winning_status', 1)
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'data' => $twod_win
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function threedWin() {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();
            $threed_win = Threedsalelist::where('winning_status', 1)
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'data' => $threed_win
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function threedWinByDate(Request $request) {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = $request->current_date;
            $threed_win = Threedsalelist::where('winning_status', 1)
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'data' => $threed_win
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function lpWin() {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();
            $lp_win = Lonepyinesalelist::where('winning_status', 1)
                ->where('agent_id', $agent->id)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'data' => $lp_win
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function lpWinByDate(Request $request) {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = $request->current_date;
            $lp_win = Lonepyinesalelist::where('winning_status', 1)
                ->where('agent_id', $agent->id)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'data' => $lp_win
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function winningThreeds() {
        $threeds = WinningNumber::where('type', '3d')->get();
        return response()->json([
            'status' => 200,
            'threeds' => $threeds
        ]);
    }

    public function winningTwods() {
        $twods = WinningNumber::where('type', '2d')->get();
        return response()->json([
            'status' => 200,
            'twods' => $twods
        ]);
    }
}
