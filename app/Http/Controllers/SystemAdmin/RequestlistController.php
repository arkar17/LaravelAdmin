<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\Guest;
use App\Models\Client;
use App\Helpers\Helper;
use App\Models\Requestlist;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRefereeRequest;
use App\Http\Requests\UpdateRefereeRequest;

class RequestlistController extends Controller
{
    public function refereerequests()
    {
        $roles = Role::all();
        $refereerequests=User::where('status','=',1)->where('request_type','=','referee')->get();
        return view('system_admin.requestlist.refereerequests', compact('refereerequests','roles'));
    }
    public function refereedecline($id)
    {
        $refereerequest = User::findOrFail($id);
        $refereerequest->status = '3';//0=pending,1=accept,2=decline
        $refereerequest->update();

        $refereerequest->update();
        return redirect()->back()->with('success', 'Referee Decline');
    }

    public function operationstaffrequests()
    {
        $operationstaffs = User::where('status','=',1)->where('request_type','=','operationstaff')->get();

        // dd($operation_staffs->toArray());
        return view('system_admin.requestlist.operationstaffrequests', compact('operationstaffs'));
    }
}
