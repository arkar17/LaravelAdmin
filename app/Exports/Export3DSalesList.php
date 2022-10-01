<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Referee;
use App\Models\Threedsalelist;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class Export3DSalesList implements FromCollection, WithHeadings
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
        $date = Carbon::Now()->toDateString();
        $agents = Agent::where('id' ,'>' ,0)->where('referee_id',$referee->id)->pluck('id')->toArray();
        return Threedsalelist::select('users.name','threedsalelists.customer_name','threeds.number',
                                      'threedsalelists.sale_amount')
        ->whereIn('threedsalelists.agent_id',$agents)
        ->join('threeds','threeds.id','threedsalelists.threed_id')
        ->join('agents','agents.id','threedsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->where('threedsalelists.status',1)
        ->where('threedsalelists.date',$date)
        ->orderBy('threedsalelists.id','desc')
        ->get();
    }
}
