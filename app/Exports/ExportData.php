<?php

namespace App\Exports;

use App\Invoice;
use App\Models\Agent;
use App\Models\Twodsalelist;
use App\Models\Threedsalelist;
use App\Models\Lonepyinesalelist;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportData implements FromView
{
    protected $id;

 function __construct($id) {
        $this->id = $id;
 }
 public function view(): View
 {
     return view('system_admin.profile.agentExport', [
         'agent'=>Agent::findOrFail($this->id),
         'twod_salelists'=>Twodsalelist::select('id','customer_name','customer_phone',
                                                DB::raw('SUM(twodsalelists.sale_amount)as sale_amount'))
                                                ->where('agent_id','=',$this->id)->groupBy('customer_name')
                                                ->get(),
         'threed_salelists'=>Threedsalelist::select('id','customer_name','customer_phone',
                                                    DB::raw('SUM(threedsalelists.sale_amount)as sale_amount'))
                                                    ->where('agent_id','=',$this->id)->groupBy('customer_name')
                                                    ->get(),
         'lonepyine_salelists'=>Lonepyinesalelist::select('id','customer_name','customer_phone',
                                                        DB::raw('SUM(lonepyinesalelists.sale_amount)as sale_amount'))
                                                        ->where('agent_id','=',$this->id)->groupBy('customer_name')
                                                        ->get(),

         // dd($userId)
     ]);
 }
}
