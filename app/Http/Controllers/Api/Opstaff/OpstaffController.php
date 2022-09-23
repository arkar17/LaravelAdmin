<?php

namespace App\Http\Controllers\Api\Opstaff;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Referee;
use Illuminate\Http\Request;
use App\Models\Operationstaff;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OpstaffController extends Controller
{

    // Opstaff Profile
    public function opstaffProfile()
    {
        $user = auth()->user();

        if ($user) {
            $op_staff = Operationstaff::where('user_id', $user->id)->with('user')->first();


            return response()->json([
                'status' => 200,
                'data' => $op_staff
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized user',
            ]);
        }
    }

    // Opstaff Profile update
    public function opstaffProfileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation error',
                'data' => $validator->errors(),
            ]);
        }

        $user = auth()->user();

        if ($user) {
            $imageName = null;
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $imageName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/image/', $imageName);
            }

            $op_staff = Operationstaff::where('user_id', $user->id)->first();
            $user = User::findOrFail($user->id);

            $user->name = $request->name;
            $op_staff->image = $imageName;

            $user->save();
            $op_staff->save();

            return response()->json([
                'status' => 200,
                'message' => "Operation profile updated successfully",
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized user',
            ]);
        }
    }

    // public function acceptReferee($id)
    // {
    //     $user = auth()->user();
    //     if ($user) {
    //         // $usr = User::where('id', $user->id)->first();
    //         // $usr->status =  '2';

    //         $op_staff = Operationstaff::where('user_id', $user->id)->first();

    //         $referee = Referee::where('operationstaff_id', $op_staff->id)->get();

    //         // return $usr;

    //         $referee = new Referee();

    //         $referee->user_id = $usr->id;
    //         $referee->operationstaff_id = $op_staff->id;
    //         $referee->role_id = 5;

    //         // $rf = Referee::latest()->first()->id;
    //         $rf = count(Referee::all());
    //         return $rf;
    //         $referee->referee_code = "RF" . $rf + 1;

    //         $usr->status = '2';

    //         $referee->save();
    //         $usr->save();

    //         return response()->json([
    //             'status' => 200,
    //             'data' => $usr,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 401,
    //             'message' => 'Unauthorized usesrs',
    //         ]);
    //     }
    // }

    public function acceptReferee($id)
    {
        $DateTime = Carbon::now()->addDay(7);

        $user = User::findOrFail($id);
        $user->status = 2;
        $otcode = strtoupper($user->operationstaff_code);
        $operationstaff = Operationstaff::where('operationstaff_code', '=', $otcode)->first();
        if (!empty($operationstaff->id)) {
            $operationstaff_id = $operationstaff->id;
        } else {
            return response()->json([
                'message' => 'Invalid ot code'
            ]);
        }
        $user->operationstaff_code = $otcode;
        $user->assignRole('referee');

        $user->update();

        $referee = new Referee();
        $countRefereeCode = Referee::count('referee_code');

        if ($countRefereeCode == 0) {
            $referee->referee_code = 'RF1';
        } else {
            $LatestRefereeID = Referee::max('referee_code');

            $newid = substr($LatestRefereeID, 2, 5);
            $referee->referee_code = 'RF' . intval($newid) + 1;
        }
        $referee->user_id = $user->id;
        $referee->operationstaff_id = $operationstaff_id;
        $referee->avaliable_Date = $DateTime;
        $referee->active_status = 1;

        $referee->role_id = 5;
        // if(!empty($request->role_id)){
        //     $role = Role::find($request->role_id);
        //     $user->roles()->attach($role);
        //     $referee->role_id=$request->role_id;

        // }else{

        // }
        //$referee->remark=$request->remark;

        $referee->save();

        return response()->json([
            'status' => 200,
            'message' => 'Referee accepted',
        ]);
    }
    public function declineReferee($id)
    {
        $user = auth()->user();
        if ($user) {
            $usr = User::findOrFail($id);
            $usr->status = '3';
            $usr->request_type = null;
            $usr->save();

            return response()->json([
                'status' => 200,
                'message' => "Declined successfully!",
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized usesrs',
            ]);
        }
    }

    // referee requests
    public function showRefereeRequests()
    {
        $user = auth()->user();
        if ($user) {
            $op_staff = Operationstaff::where('user_id', $user->id)->first();

            $referee_requests = User::where('request_type', 'referee')->where('status', '1')
                ->where('operationstaff_code', $op_staff->operationstaff_code)->get();

            return response()->json([
                'status' => 200,
                'referee_requests' => $referee_requests,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized users',
            ]);
        }
    }

    // show referees in operation staff profile
    public function showReferees()
    {
        $user = auth()->user();
        if ($user) {
            $op_staff = Operationstaff::where('user_id', $user->id)->first();

            $referees = Referee::where('operationstaff_id', '=', $op_staff->id)->with('user')->whereHas('user', function ($q) use ($op_staff) {
                $q->where('request_type', 'referee')->where('status', '2');
            })->get();

            return response()->json([
                'status' => 200,
                'referees' => $referees,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized users',
            ]);
        }
    }

    public function editReferee($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error!',
                'data' => $validator->errors(),
            ]);
        }
        $user = auth()->user();

        if ($user) {
            $referee = Referee::findOrFail($id);
            $usr = User::findOrFail($referee->user_id);
            $usr->name = $request->name;

            $usr->save();

            return response()->json([
                'status' => 200,
                'refereee_name' => $usr,
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized usesrs',
            ]);
        }
    }

    public function destroyReferee($id)
    {
        $user = auth()->user();
        if ($user) {
            $referee = Referee::findOrFail($id);
            $usr = User::findOrFail($referee->user_id);

            $referee->delete();
            $usr->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Referee deleted success',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized users',
            ]);
        }
    }
}
