<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TwodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function twoD() {
        return view('system_admin.2D.index');
    }
}
