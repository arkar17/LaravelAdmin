<?php

namespace App\Http\Controllers\Api\Pusher;

use Pusher\Pusher;
use App\Models\Twod;
use App\Models\TwodSalelist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TwoDController extends Controller
{
    public function notification()
    {
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

        $date = Carbon::now()->toDateString();
        $twods = Twod::where('round', 'morning')->where('date', $date)->get();
        $pusher->trigger('notify-channel', 'App\\Events\\Notify', $twods);
        return response()->json([
            'status' => 200,
            'data' => $twods
        ]);
    }
}
