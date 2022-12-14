<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashinCashoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashin_cashouts', function (Blueprint $table) {
            $table->id();
            $table->integer('agent_id');
            $table->integer('referee_id');
            $table->bigInteger('coin_amount')->default(0);
            $table->integer('status')->nullable();
            $table->bigInteger('payment')->default(0);
            $table->bigInteger('remaining_amount')->default(0);
            $table->bigInteger('withdraw')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashin_cashouts');
    }
}
