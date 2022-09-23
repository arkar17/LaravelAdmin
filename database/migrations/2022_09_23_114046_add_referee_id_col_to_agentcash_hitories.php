<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefereeIdColToAgentcashHitories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agentcash_histories', function (Blueprint $table) {
            $table->integer('referee_id')->after('agent_id');
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
            $table->dropColumn('referee_id');
        });
    }
}
