<?php

namespace App\Console\Commands;

use App\Models\CashinCashout;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddCoinAmtForAgent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinAmt:agent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $twod = DB::select("select ts.agent_id , SUM(ts.sale_amount) as twodSales FROM twodsalelists ts left join cashin_cashouts cc on ts.agent_id = cc.agent_id where ts.status = 1 and ts.winning_status = 1 group by ts.agent_id");
        $threed = DB::select("select ts.agent_id , SUM(ts.sale_amount) as threeDSales FROM threedsalelists ts left join cashin_cashouts cc on ts.agent_id = cc.agent_id where ts.status = 1 and ts.winning_status = 1 group by ts.agent_id");
        $lonePyaing = DB::select("select ts.agent_id , SUM(ts.sale_amount) as lonePyaingSales FROM lonepyinesalelists ts left join cashin_cashouts cc on ts.agent_id = cc.agent_id where ts.status = 1 and ts.winning_status = 1 group by ts.agent_id");
        $mainCoin = DB::select("select cc.agent_id,cc.coin_amount from cashin_cashouts cc");
        foreach($mainCoin as $main){
            // dump ($main->coin_amount);

            if($twod == null && $threed != null && $lonePyaing != null){
                foreach($lonePyaing as $re2){
                    foreach($threed as $re1){
                        $coin = $re1->threeDSales + $re2->lonePyaingSales + $main->coin_amount;
                        info(CashinCashout::where('id','=',$re1->agent_id)->update(['coin_amount'=>$coin]));
                    }
                }
            }
            if($twod != null && $threed == null && $lonePyaing != null){
                foreach($twod as $re){
                    foreach($lonePyaing as $re2){
                        $coin = $re->twodSales + $re2->lonePyaingSales + $main->coin_amount;
                        info(CashinCashout::where('id','=',$re->agent_id)->update(['coin_amount'=>$coin]));
                    }
                }
            }
            if($twod != null && $threed != null && $lonePyaing == null){
                foreach($twod as $re){
                    foreach($threed as $re1){
                        $coin = $re->twodSales + $re1->threeDSales + $main->coin_amount;
                        info(CashinCashout::where('id','=',$re->agent_id)->update(['coin_amount'=>$coin]));
                    }
                }
            }
            if($twod != null && $threed == null && $lonePyaing == null){
                foreach($twod as $re){
                        $coin = $re->twodSales + $main->coin_amount;
                        info(CashinCashout::where('id','=',$re->agent_id)->update(['coin_amount'=>$coin]));
                }
            }
            else{
                foreach($twod as $re){
                foreach($threed as $re1){
                    foreach($lonePyaing as $re2){
                        $coin = $re->twodSales + $re1->threeDSales + $re2->lonePyaingSales + $main->coin_amount;
                        info(CashinCashout::where('id','=',$re->agent_id)->update(['coin_amount'=>$coin]));
                        }
                    }
                }
            }
        }
    }
}
