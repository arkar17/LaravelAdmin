<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToAgentcashHitories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agentcash_histories', function (Blueprint $table) {
           $table->bigInteger('agent_payment')->default(0)->after('agent_cash');
           $table->bigInteger('agent_withdraw')->default(0)->after('agent_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agentcash_histories', function (Blueprint $table) {
            $table->dropColumn(['agent_payment', 'agent_withdraw']);
        });
    }
}
