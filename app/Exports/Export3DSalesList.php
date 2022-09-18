<?php

namespace App\Exports;

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
            'No',
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
        return Threedsalelist::select('threedsalelists.id','users.name','threedsalelists.customer_name','threeds.number',
                                      'threedsalelists.sale_amount')
        ->whereIn('threedsalelists.agent_id',$agents)
        ->where('threedsalelists.status',1)
        ->orderBy('threedsalelists.id','desc')
        ->join('threeds','threeds.id','threedsalelists.threed_id')
        ->join('agents','agents.id','threedsalelists.agent_id')
        ->join('users','users.id','agents.user_id')
        ->get();
    }
}
