<?php

namespace App\Http\Controllers;

use App\Models\Threedsalelist;
use App\Models\Twodsalelist;
use App\Models\WinningResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WinningResultController extends Controller
{
    public function winningresult() {
        return view('winningresult');
    }

    public function storeWinningresult(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required'
        ]);

        $winning_result = new WinningResult();
        $winning_result->number = $request->number;
        $winning_result->type = $request->type;
        $winning_result->save();

        return redirect()->back();
    }
}
