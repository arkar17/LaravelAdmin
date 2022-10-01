<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Twodsalelist;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class Export2DSalesList implements FromCollection, WithHeadings
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
        $referee =Referee::where('user_id',$user)->first();
        $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();
        $date = Carbon::Now()->toDateString();
          return Twodsalelist::select('users.name','twodsalelists.customer_name','twods.number','twodsalelists.sale_amount')
            ->join('agents','agents.id','twodsalelists.agent_id')
            ->join('users','users.id','agents.user_id')
            ->join('twods','twods.id','twodsalelists.twod_id')
            ->whereIn('twodsalelists.agent_id',$agents)
            ->where('twodsalelists.status',1)
            ->where('twods.date',$date)
            ->orderBy('twodsalelists.id','desc')
            ->get();
    }
}
