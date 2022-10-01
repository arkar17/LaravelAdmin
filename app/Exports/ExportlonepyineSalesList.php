<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Lonepyinesalelist;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportlonepyineSalesList implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'Agent Name',
            'Customer Name',
            'Number','Amount'
        ];
    }
    public function collection()
    {
        $user = auth()->user()->id;
        $date = Carbon::Now()->toDateString();
        $referee =Referee::where('user_id',$user)->first();
        $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();
        return Lonepyinesalelist::select('users.name','lonepyinesalelists.customer_name','lonepyines.number','lonepyinesalelists.sale_amount',
        )
        ->join('agents','agents.id','lonepyinesalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->join('lonepyines','lonepyines.id','lonepyinesalelists.lonepyine_id')
        ->whereIn('lonepyinesalelists.agent_id',$agents)
        ->where('lonepyinesalelists.status',1)
        ->where('lonepyines.date',$date)
        ->get();
    }
}
