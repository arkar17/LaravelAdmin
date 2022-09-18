<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Models\User;
use App\Models\Guest;
use App\Models\Client;
use App\Models\Referee;
use Illuminate\Http\Request;
use App\Models\Operationstaff;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOperationStaffRequest;

class OperationStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $operation_staffs = Client::whereNotNull('operationstaff_id')->get();
        $operation_staffs=Operationstaff::all();
        $operation_staffs=DB::select('select u.name,u.phone,op.operationstaff_code,op.image,op.id FROM operationstaffs op left join users u on op.user_id = u.id;');
        return view('system_admin.operationstaff.index', compact('operation_staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system_admin.operationstaff.create');
    }


    public function store(StoreOperationStaffRequest $request)
    {
    }

    public function operationaccept($id)
    {
        $user = User::findOrFail($id);
        $user->status = 2;

        $user->update();

        $operationstaff =new Operationstaff();
        $countOperationCode = Operationstaff::count('operationstaff_code');

        if($countOperationCode == 0 ){
            $operationstaff->operationstaff_code = 'OT1';
        }
        else{
            $LatestoperationstaffID = operationstaff::max('operationstaff_code');

            $newid = substr($LatestoperationstaffID, 2, 5);
            $operationstaff->operationstaff_code= 'OT'.intval($newid)+1;
        }
        $operationstaff->user_id=$id;

        $operationstaff->save();

        return redirect()->back()->with('success', 'New Operation Staff is created successfully!');
    }

    public function operationdecline($id)
     {
        $user = User::findOrFail($id);
        $user->status = '3';//0=null,1=pending,2=accept,3=decline
        $user->request_type =null;
        $user->update();

        return redirect()->back()->with('success', 'Operationstaff Decline');
     }

    public function show($id)
    {
        // $operation_staff =Client::findOrFail($id);
        // return view('system_admin.operationstaff.show', compact('operation_staff'));
    }


    public function edit($id)
    {
        $operation_staff = Operationstaff::findOrFail($id);
        return view('system_admin.operationstaff.edit', compact('operation_staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $operationstaff = Operationstaff::findOrFail($id);

        $user_id=$operationstaff->user_id;
        $user = User::findOrFail($user_id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = $user->passowrd ?? $request->password;
        $user->update();

        $profile_img_name = $operationstaff->image;

        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put(
                'image/' . $profile_img_name,
                file_get_contents($profile_img_file)
            );
        }
        $operationstaff->image = $profile_img_name;

        $operationstaff->update();

        return redirect()->route('operation-staff.index')->with('success', 'New Operation Staff is Updated successfully!');
    }

    public function promoteos($id)
{
    $user = User::findOrFail($id);
    $user->status = 2;
    $user->operationstaff_code=null;
    $user->request_type='operationstaff';
    $user->update();

    $operationstaff =new Operationstaff();
    $countOperationCode = Operationstaff::count('operationstaff_code');

    if($countOperationCode == 0 ){
        $operationstaff->operationstaff_code = 'OT1';
    }
    else{
        $LatestoperationstaffID = operationstaff::max('operationstaff_code');

        $newid = substr($LatestoperationstaffID, 2, 5);
        $operationstaff->operationstaff_code= 'OT'.intval($newid)+1;
    }
    $operationstaff->user_id=$id;

    $operationstaff->save();

    return redirect()->back()->with('success', 'New Operation Staff is created successfully!');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operation_staff = Operationstaff::findOrFail($id);
        $operation_staff->delete();

        $user=User::findOrFail($operation_staff->user_id);
        $user->status='0';
        $user->request_type=null;

        $user->update();

        return redirect ()->back()->with('success', 'Operationstaff is deleted successfully!');
    }
}
