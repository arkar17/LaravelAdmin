<?php

namespace App\Http\Controllers\Api\SaleDayBook;

use Carbon\Carbon;
use App\Models\Agent;

use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Models\Threedsalelist;
use App\Models\Lonepyinesalelist;
use App\Http\Controllers\Controller;

class SaleDayBookController extends Controller
{
    public function twoDSaleDayBook(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();
            $accepted_twod_lists = Twodsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get()->groupBy('customer_phone');
            return response()->json([
                'status' => 200,
                'data' => $accepted_twod_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }


    public function threeDSaleDayBook(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();
            $accepted_threed_lists = Threedsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get()->groupBy('customer_phone');

                return response()->json([
                    'status' => 200,
                    'data' => $accepted_threed_lists
                ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function lonePyaingSaleDayBook() {
        $user = auth()->user();
        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $current_date = Carbon::now('Asia/Yangon')->toDateString();

            $accepted_lonepyine_lists = Lonepyinesalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get()->groupBy('customer_phone');

                return response()->json([
                    'status' => 200,
                    'data' => $accepted_lonepyine_lists
                ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }
}
