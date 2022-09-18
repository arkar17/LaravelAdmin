<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRefereeRequest;
use App\Http\Requests\UpdateRefereeRequest;

class RequestlistController extends Controller
{
    public function refereerequests()
    {
        $referees = Client::whereNotNull('referee_id')->get();

        // dd($operation_staffs->toArray());
        return view('requestlist.refereerequests', compact('referees'));
    }

    public function operationstaffrequests()
    {
        $operationstaffs = Client::whereNotNull('operationstaff_id')->get();

        // dd($operation_staffs->toArray());
        return view('requestlist.operationstaffrequests', compact('operationstaffs'));
    }
}
