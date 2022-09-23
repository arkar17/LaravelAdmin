<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent;
use App\Models\Guest;
use App\Models\Client;
use App\Helpers\Helper;
use App\Models\Referee;
use App\Models\Requestlist;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Exports\RefereeExport;
use App\Models\Operationstaff;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRefereeRequest;
use App\Http\Requests\UpdateRefereeRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RefereeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $referees=Referee::all();
        return view('system_admin.referee.index', compact('referees'));
    }


    // public function refereerequests()
    // {
    //     $referees = Client::whereNotNull('referee_id')->get();
    //     // $referees=Guest::where('status','=',1)->get();
    //     return view('system_admin.referee.refereerequests', compact('referees'));
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$rfid =Helper::IDGenerator(new User(),'referee_id',4,'RF');

        return view('system_admin.referee.create',compact('rfid'));
    }

    public function refereecreate($id)
    {
        $guest = User::findOrFail($id);

        return view('system_admin.referee.refereecreate', compact('guest'));
    }

    public function refereecreatestore(Request $request)
    {
        $user=User::findOrFail($request->user_id);
        $type=$request->request_type;
        $user->status='1';
        $user->operationstaff_code=strtoupper($request->operationstaff_code);
        $user->referee_code=strtoupper($request->referee_code);
        if($type == '1')
        {
            $user->request_type='referee';
        }elseif($type==2){
            $user->request_type='operationstaff';
        }elseif($type==3){
            $user->request_type='agent';
        }

        $user->update();

        return redirect()->back()->with('success', 'Requested successfully!');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function referee_accept(Request $request)
     {
        $DateTime = Carbon::now()->addDay(7);
        $role=Role::where('name','referee')->first();
        $role_id=$role->id;

        $user = User::findOrFail($request->user_id);
        $user->status = 2;
        $otcode=strtoupper($request->operationstaff_code);
        $operationstaff=Operationstaff::where('operationstaff_code','=',$otcode)->first();
        if(!empty($operationstaff->id )){
            $operationstaff_id=$operationstaff->id;
        }else{
            return redirect()->back()->with('success', 'Invalid Operation Staff ID');
        }
        $user->operationstaff_code=$otcode;
        $user->assignRole('referee');

        $user->update();

        $referee =new Referee();
        $countRefereeCode = Referee::count('referee_code');

        if($countRefereeCode == 0 ){
            $referee->referee_code = 'RF1';
        }
        else{
            $LatestRefereeID = Referee::max('referee_code');

            $newid = substr($LatestRefereeID, 2, 5);
            $referee->referee_code= 'RF'.intval($newid)+1;
        }
        $referee->user_id=$request->user_id;
        $referee->operationstaff_id=$operationstaff_id;
        $referee->avaliable_Date=$DateTime;
        $referee->active_status=1;

        if(!empty($request->role_id)){
            $role = Role::find($request->role_id);
            $user->roles()->attach($role);
            $referee->role_id=$request->role_id;

        }else{
            $referee->role_id=$role_id;
        }
        $referee->remark=$request->remark;

        $referee->save();

        return redirect()->back()->with('success', 'New Referee is created successfully!');
     }

     public function referee_decline($id)
     {
        $user = User::findOrFail($id);
        $user->status = '0';//0=null,1=pending,2=accept,3=decline
        $user->request_type =null;
        $user->update();

        return redirect()->back()->with('success', 'Referee Decline');
     }


    public function show($id)
    {
        $referee = User::findOrFail($id);
        return view('system_admin.referee.show', compact('referee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles=Role::all();
        $referee = Referee::findOrFail($id);
        $operationstaffs = Operationstaff::all();
        return view('system_admin.referee.edit', compact('referee','operationstaffs','roles'));
    }

    // public function export()
    // {
    //      return Excel::download(new RefereeExport, 'referee.xlsx');
    // }


    public function update(Request $request,$id)
    {
        // $role=Role::where('name','referee')->first();
        // $role_id=$role->id;

        $referee = Referee::findOrFail($id);
        if($request->hasFile('profile_img')) {
            $file = $request->file('profile_img');
            $imgName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/image/', $imgName);
        }else{
            $imgName = $referee->image;
        }
        $user_id=$referee->user_id;
        $user = User::findOrFail($user_id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->operationstaff_code = $request->operationstaff_id;

        // $assign_role = Role::where('id',$request->role_id)->first();
        // $assign_role_id=$assign_role->id;

        // $user->roles()->detach($referee->role_id);
        // $user->roles()->attach($assign_role_id);
        // $user->assignRole('referee');

        $user->update();

        $referee_code=Operationstaff::where('operationstaff_code','=',$request->operationstaff_id)->first();
     if($referee_code==null){
        return redirect()->back()->with('success', 'Invalid Operation Staff ID');
     }else{
        $id=$referee_code->id;
     }


        $referee->operationstaff_id=$id;
        // $referee->role_id=$request->role_id;
        $referee->user->password = $referee->passowrd ?? $request->password;
        $referee->image = $imgName;
        $user_status=$request->active_status;
        // if(!empty($request->avaliable_date)){
        //     $referee->avaliable_date=$request->avaliable_date;
        //     $referee->active_status=1;
        // }else{
            if($user_status == 1){
                $DateTime = Carbon::now()->addDay(7);
                $referee->avaliable_date= $DateTime;
                $referee->active_status=1;
            }else{
                $referee->avaliable_date=null;
                $referee->active_status=0;
               }
        // }
        // $referee->remark = $request->remark;

        $referee->update();

        return redirect()->route('referee.index')->with('success', 'Referee is updated successfully!');
    }



    public function createPDF () {

        //$pdf = PDF::loadView('front.cars.pdfExport', compact('group_arr'));
        $referees = Referee::all();
        $pdf = PDF::loadView('system_admin.referee.show',compact('referees'));
        return $pdf->download('invoice.pdf');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referee = Referee::findOrFail($id);

        $user=User::findOrFail($referee->user_id);
        $user->status='0';
        $user->request_type=null;

        $role = Role::find($referee->role_id);
        $user->roles()->detach($role);
        $user->roles()->detach();
        $user->update();
        $referee->delete();

        return redirect ()->back()->with('success', 'Referee is deleted successfully!');


    }
}
