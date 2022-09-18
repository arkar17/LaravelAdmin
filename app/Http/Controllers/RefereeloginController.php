<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RefereeloginController extends Controller
{
    public function authentication(Request $request)
    {
        $user=User::where('phone','=',$request->phone)
                    ->where('password','=', $request->password)->get();
        dd($user);

    }
}
