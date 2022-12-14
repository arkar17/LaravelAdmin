<?php

namespace App\Http\Controllers\Referee;

use auth;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Agent;
use App\Models\Threed;
use App\Models\Referee;
use App\Models\Lonepyine;
use App\Models\LonePyaing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ThreeDManageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ThreeDmanage()
    {
        $user = auth()->user();

        // $user = auth()->user()->id;
                $currentDate = Carbon::now()->toDateString();
                $time = Carbon::Now()->toTimeString();
                if ($user) {
                    $referee = Referee::where('user_id', $user->id)->first();
                    $rate = DB::Select("SELECT t.compensation FROM threeds t where referee_id = $referee->id ORDER BY id DESC LIMIT 1");
                    if($time > 12){
                    $lonepyaing = DB::select("SELECT aa.id,aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
                    from (SELECT * FROM
                     ( SELECT * FROM lonepyines where referee_id = '$referee->id'
                     ORDER BY id DESC LIMIT 20 )sub ORDER BY id ASC) aa LEFT join agents on
                     aa.referee_id = agents.id LEFT join lonepyinesalelists ts on
                     ts.lonepyine_id = aa.id where aa.referee_id = '$referee->id' and aa.date = '$currentDate' and aa.round = 'Evening'
                     group by aa.number");
                    $lonepyaing_sale_lists = json_decode(json_encode ( $lonepyaing ) , true);
                    $lonepyaing_sale_lists = collect($lonepyaing_sale_lists)->sortBy('id')->toArray();
                    // $lonepyaing_sale_lists = array_values(array_sort($lonepyaing, function ($key, $value) {
                    //     return $value['id'];
                    // }));
                    // dd($lonepyaing_sale_lists);
                }
                else{
                    $lonepyaing = DB::select("SELECT aa.id, aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
                    from (SELECT * FROM
                     ( SELECT * FROM lonepyines where referee_id = '$referee->id'
                     ORDER BY id DESC LIMIT 20 )sub ORDER BY id ASC) aa LEFT join agents on
                     aa.referee_id = agents.id LEFT join lonepyinesalelists ts on
                     ts.lonepyine_id = aa.id where aa.referee_id = '$referee->id' and aa.date = '$currentDate' and aa.round = 'Morning'
                      group by aa.number");
                    $lonepyaing_sale_lists = json_decode(json_encode ( $lonepyaing ) , true);
                    $lonepyaing_sale_lists = collect($lonepyaing_sale_lists)->sortBy('id')->toArray();
                }
                    }

                            return view('RefereeManagement.threedManage', compact('rate','lonepyaing_sale_lists'));

    }

    public function TnLmanage()
    {
                $user = auth()->user();
                $currentDate = Carbon::now()->toDateString();
                $time = Carbon::Now()->toTimeString();
                if ($user) {
                    $referee = Referee::where('user_id', $user->id)->first();
                    $rate = DB::Select("SELECT t.compensation FROM threeds t where referee_id = $referee->id ORDER BY id DESC LIMIT 1");
                    if($time > 12){
                    $lonepyaing_sale_lists = DB::select("SELECT aa.id,aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
                    from (SELECT * FROM
                     ( SELECT * FROM lonepyines where referee_id = '$referee->id'
                     ORDER BY id DESC LIMIT 20 )sub ORDER BY id ASC) aa LEFT join agents on
                     aa.referee_id = agents.id LEFT join lonepyinesalelists ts on
                     ts.lonepyine_id = aa.id where aa.referee_id = '$referee->id' and aa.date = '$currentDate' and aa.round = 'Evening'
                     group by aa.number");
                }
                else{
                    $lonepyaing_sale_lists = DB::select("SELECT aa.id, aa.number , aa.max_amount , aa.compensation , SUM(ts.sale_amount) as sales
                    from (SELECT * FROM
                     ( SELECT * FROM lonepyines where referee_id = '$referee->id'
                     ORDER BY id DESC LIMIT 20 )sub ORDER BY id ASC) aa LEFT join agents on
                     aa.referee_id = agents.id LEFT join lonepyinesalelists ts on
                     ts.lonepyine_id = aa.id where aa.referee_id = '$referee->id' and aa.date = '$currentDate' and aa.round = 'Morning'
                      group by aa.number");
                }
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

                        $data = 'Updated';
                        $pusher->trigger('lonepyine-channel.'.$referee->id, 'App\\Events\\lonepyine',  $data);
                        return response()->json([
                            'status' => 200,
                            'data' => ['salesList' => $lonepyaing_sale_lists]
                        ]);

                            // return view('RefereeManagement.threedManage',compact('rate'));
    }

    public function threeDManage2()
    {
        $user = auth()->user()->id;
        $rate = DB::Select("SELECT t.compensation FROM threeds t where referee_id = $user ORDER BY id DESC LIMIT 1");
        // $user = auth()->user();
        // $currenDate = Carbon::now()->toDateString();
                $time = Carbon::Now()->toTimeString();
                if ($user) {
                    $referee = Referee::where('user_id', $user)->first();
                    // $agent = Agent::where('user_id', $user->id)->with('referee')->first();
                    // $referee = Referee::where('user_id', $agent->referee->user_id)->with('user')->first();
                    if($time > 12){
                    $lonepyaing_sale_lists = DB::select("Select * from (SELECT id,number FROM threeds t where referee_id = '$referee->id'  ORDER BY id DESC LIMIT 350)sub ORDER BY id ASC;");
                }
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

                        $data['message'] = 'Hello XpertPhp';
                        $pusher->trigger('threed-channel.'.$referee->id, 'App\\Events\\sendthreed',  $rate);
                        return response()->json([
                            'status' => 200,
                            'data' => $rate
                        ]);

                            // return view('RefereeManagement.threedManage',compact('rate'));
    }

    public function ThreeDManageCreate(Request $request)
    {
        $rate = $request->number;
        $date = Carbon::Now();
        $user = auth()->user()->id;
        if($user){
            $referee = Referee::where('user_id', $user)->first();
            for($i=0; $i <= 999 ; $i++){
                if(strlen($i) == 1){
                $threeD = new Threed();
                $threeD->number = '00'.$i;
                $threeD->compensation = $rate;
                $threeD->date = $date;
                $threeD->referee_id = $referee->id;
                $threeD->save();
                }
                elseif(strlen($i) == 2){
                    $threeD = new Threed();
                    $threeD->number = '0'.$i;
                    $threeD->compensation = $rate;
                    $threeD->date = $date;
                    $threeD->referee_id = $referee->id;
                    $threeD->save();
                    }
                else{
                $threeD = new Threed();
                $threeD->number = $i;
                $threeD->compensation = $rate;
                $threeD->date = $date;
                $threeD->referee_id = $referee->id;
                $threeD->save();
                }

            }
            $rate = DB::Select("SELECT t.compensation FROM threeds t where referee_id = $referee->id ORDER BY id DESC LIMIT 1");
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

                $data['message'] = 'Hello XpertPhp';
                $pusher->trigger('threed-channel.'.$referee->id, 'App\\Events\\sendthreed',  $rate);
        }


        return redirect()->back();
    }
    public function LonePyaingManageCreate(Request $request)
    {
    $lonePyaingList = $request->lonepyaing; // json string
    $date = Carbon::Now();
    $time = Carbon::Now()->toTimeString();
    $user = auth()->user()->id;
    if($user){
        $referee = Referee::where('user_id', $user)->first();
        if($time > 12){
            foreach ($lonePyaingList as $lonePyaingLists) {
                $LonePyaing = new Lonepyine();
                //  intval($num)
                 $maxAmt = $lonePyaingLists['maxAmount'];
                 $comp = $lonePyaingLists['compensation'];
                 $LonePyaing->number = $lonePyaingLists['lonepyineNumber'];
                 $LonePyaing->date = $date;
                 $LonePyaing->max_amount = intval($maxAmt);
                 $LonePyaing->compensation = $comp;
                 $LonePyaing->round =  'Evening';
                 $LonePyaing->referee_id = $referee->id;
                 $LonePyaing->save();
            }
        }
        else{
            foreach ($lonePyaingList as $lonePyaingLists) {
                $LonePyaing = new Lonepyine();
               //  intval($num)
                $maxAmt = $lonePyaingLists['maxAmount'];
                $comp = $lonePyaingLists['compensation'];
                $LonePyaing->number = $lonePyaingLists['lonepyineNumber'];
                $LonePyaing->date = $date;
                $LonePyaing->max_amount = intval($maxAmt);
                $LonePyaing->compensation = $comp;
                $LonePyaing->round =  'Morning';
                $LonePyaing->referee_id = $referee->id;
                $LonePyaing->save();
            }
        }
    }
}

}

