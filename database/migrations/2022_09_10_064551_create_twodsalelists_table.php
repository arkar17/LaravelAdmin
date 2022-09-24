<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwodsalelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twodsalelists', function (Blueprint $table) {
            $table->id();
            $table->integer('twod_id');
            $table->integer('agent_id');
            $table->bigInteger('sale_amount')->default(0);
            $table->string('status')->default(0);
            $table->boolean('winning_status')->default(0);
            $table->date('date')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
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
        Schema::dropIfExists('twodsalelists');
    }
}
