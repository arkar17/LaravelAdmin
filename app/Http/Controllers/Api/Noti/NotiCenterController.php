<?php

namespace App\Http\Controllers\Api\Noti;

use Carbon\Carbon;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lonepyinesalelist;
use App\Models\Threedsalelist;
use App\Models\Twodsalelist;

class NotiCenterController extends Controller
{

    public function getAllNotifications()
    {
        $user = auth()->user();
        $current_date = Carbon::now('Asia/Yangon')->toDateString();
        $from_date = Carbon::now('Asia/Yangon')->subDays(30)->toDateString();


        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();

            $accepted_twod_lists = Twodsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date, $from_date) {
                    $q->whereBetween('date', [$from_date, $current_date]);
                })->get();

            $accepted_threed_lists = Threedsalelist::where('status', '1')->where('agent_id', $agent->id)->whereHas('twod', function ($q) use ($current_date, $from_date) {
                $q->whereBetween('date', [$from_date, $current_date]);
            })->get();

            $accepted_lonepyine_lists = Lonepyinesalelist::where('status', '1')
                ->where('agent_id', $agent->id)
                ->whereHas('lonepyine', function ($q) use ($current_date, $from_date) {
                    $q->whereBetween('date', [$from_date, $current_date]);
                })->get();

            return response()->json([
                'status' => 200,
                'accepted_twod_lists' => $accepted_twod_lists,
                'accepted_threed_lists' => $accepted_threed_lists,
                'accepted_lonepyine_lists' => $accepted_lonepyine_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized user'
            ]);
        }
    }

    // for today notification
    public function getCurrentNotification()
    {
        $user = auth()->user();
        $current_date = Carbon::now('Asia/Yangon')->toDateString();

        if ($user) {

            $agent = Agent::where('user_id', $user->id)->first();

            $accepted_twod_lists = Twodsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();

            $accepted_threed_lists = Threedsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();

            $accepted_lonepyine_lists = Lonepyinesalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('twod')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();

            return response()->json([
                'status' => 200,
                'accepted_twod_lists' => $accepted_twod_lists,
                'accepted_threed_lists' => $accepted_threed_lists,
                'accepted_lonepyine_lists' => $accepted_lonepyine_lists,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized user'
            ]);
        }
    }
}
