<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TwodsController extends Controller
{
    public function twoD() {
        return view('system_admin.2D.index');
    }
}
