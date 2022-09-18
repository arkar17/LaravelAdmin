<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lonepyinesalelist;
use App\Models\Threedsalelist;
use App\Models\Twodsalelist;
use App\Models\Agent;

class AcceptedTransitionController extends Controller
{
    public function twodAcceptedTransitions(Request $request)
    {
        $user = auth()->user();

        $current_date = Carbon::now('Asia/Yangon')->toDateString();

        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $accepted_twod_lists = Twodsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'accepted_twod_lists' => $accepted_twod_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }


    public function twodAcceptedTransitionsByDate(Request $request)
    {
        $user = auth()->user();

        $current_date = $request->current_date;

        if ($user) {
            $agent = Agent::where('user_id', $user->id)->first();
            $accepted_twod_lists = Twodsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'accepted_twod_lists' => $accepted_twod_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function threedAcceptedTransitions(Request $request)
    {
        $user = auth()->user();

        $current_date = Carbon::now('Asia/Yangon')->toDateString();

        if ($user) {
            $agent =  Agent::where('user_id', $user->id)->first();
            $accepted_threed_lists = Threedsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'accepted_threed_lists' => $accepted_threed_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function threedAcceptedTransitionsByDate(Request $request)
    {
        $user = auth()->user();

        $current_date = $request->current_date;

        if ($user) {
            $agent =  Agent::where('user_id', $user->id)->first();
            $accepted_threed_lists = Threedsalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'accepted_threed_lists' => $accepted_threed_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function lonepyineAcceptedTransitions(Request $request)
    {
        $user = auth()->user();

        $current_date = Carbon::now('Asia/Yangon')->toDateString();

        if ($user) {
            $agent =  Agent::where('user_id', $user->id)->first();
            $accepted_lonepyine_lists = Lonepyinesalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'accepted_lonepyaing_lists' => $accepted_lonepyine_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function lonepyineAcceptedTransitionsByDate(Request $request)
    {
        $user = auth()->user();

        $current_date = $request->current_date;

        if ($user) {
            $agent =  Agent::where('user_id', $user->id)->first();
            $accepted_lonepyine_lists = Lonepyinesalelist::where('status', '1')
                ->where('agent_id', $agent->id)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();
            return response()->json([
                'status' => 200,
                'accepted_lonepyaing_lists' => $accepted_lonepyine_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }
}
