<?php

namespace App\Http\Controllers\SystemAdmin\phaseTwo\matches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index() {
        return view('system_admin.phaseTwo.matches.index');
    }
}
