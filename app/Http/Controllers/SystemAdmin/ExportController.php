<?php

namespace App\Http\Controllers\SystemAdmin;

use PDF;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Lonepyine;
use App\Exports\DataExport;
use App\Exports\ExportData;
use App\Models\Twodsalelist;
use Illuminate\Http\Request;
use App\Exports\RefereeExport;
use App\Models\Threedsalelist;
use App\Models\Lonepyinesalelist;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function export()
    {
        //  return Excel::download(new RefereeExport, 'referee.xlsx');
         return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    public function createPDF () {

        //$pdf = PDF::loadView('front.cars.pdfExport', compact('group_arr'));
        $referees = Referee::all();
        $pdf = PDF::loadView('system_admin.referee.show',compact('referees'));
        return $pdf->download('invoice.pdf');

    }

    public function customer_export(Request $request)
    {
        //  return Excel::download(new DataExport, 'customer_data.xlsx');
        return Excel::download(new ExportData($request->id), 'customer_data.xlsx');
    }

    public function customer_createPDF (Request $request) {

        //$pdf = PDF::loadView('front.cars.pdfExport', compact('group_arr'));
        // $twodsalelists = Twodsalelist::all();
        // $threedsalelists = Threedsalelist::all();
        // $lonepyinesalelists = Lonepyinesalelist::all();

        $twod_salelists=Twodsalelist::select('agents.id','users.name','twodsalelists.customer_name','twodsalelists.customer_phone',DB::raw('SUM(twodsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','twodsalelists.agent_id')
                        ->join('users','users.id','agents.user_id')
                        ->where('agent_id',$request->id)
                        ->where('twodsalelists.status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $threed_salelists=Threedsalelist::select('agents.id','users.name','threedsalelists.customer_name','threedsalelists.customer_phone',DB::raw('SUM(threedsalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','threedsalelists.agent_id')
                        ->join('users','users.id','agents.user_id')
                        ->where('agent_id',$request->id)
                        ->where('threedsalelists.status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $lonepyine_salelists=Lonepyinesalelist::select('agents.id','users.name','lonepyinesalelists.customer_name','lonepyinesalelists.customer_phone',DB::raw('SUM(lonepyinesalelists.sale_amount)as Amount'))
                        ->join('agents','agents.id','lonepyinesalelists.agent_id')
                        ->join('users','users.id','agents.user_id')
                        ->where('agent_id',$request->id)
                        ->where('lonepyinesalelists.status',1)
                        ->groupBy('customer_name','customer_phone')
                        ->get()->toArray();

        $output = array_merge($twod_salelists,$threed_salelists,$lonepyine_salelists);
        $results = array_reduce($output, function($carry, $item){
            if(!isset($carry[$item['customer_name']])){
            $carry[$item['customer_name']] = ['customer_name'=>$item['customer_name'],'name'=>$item['name'],'customer_phone'=>$item['customer_phone'],'Amount'=>$item['Amount']];
            } else {
            $carry[$item['customer_name']]['Amount'] += $item['Amount'];
            }
            return $carry;
            });

        $agent=Agent::findOrFail($request->id);
        $pdf = PDF::loadView('system_admin.referee.show',compact('results'));
        return $pdf->download('customer_data.pdf');

    }
}
