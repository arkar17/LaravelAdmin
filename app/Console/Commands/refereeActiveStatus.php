<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Referee;
use Illuminate\Console\Command;

class refereeActiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referee:active_status';

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
        info(Referee::whereDate('avaliable_date','<',Carbon::now())->update(['active_status'=>'0']));
    }
}
