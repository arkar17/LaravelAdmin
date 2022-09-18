<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
class PusherNotificationController extends Controller
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

        $data['message'] = 'Referee Request';
        $pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);

    }
}
