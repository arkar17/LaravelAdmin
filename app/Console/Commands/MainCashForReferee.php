<?php

namespace App\Console\Commands;

use App\Models\Referee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MainCashForReferee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maincash:referee';

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
        $result = DB::select("Select (SUM(ts.sale_amount)+SUM(tr.sale_amount)) maincash ,re.id From agents a left join referees re on re.id = a.referee_id left join twodsalelists ts on ts.agent_id = a.id and ts.status = 1 left join threedsalelists tr on tr.agent_id = a.id and tr.status = 1 left join lonepyinesalelists ls on ls.agent_id = a.id and ls.status = 1 Group By re.id");
        foreach($result as $re){
         info(Referee::where('id','=',$re->id)->update(['main_cash'=>$re->maincash]));
      }
    }
}
