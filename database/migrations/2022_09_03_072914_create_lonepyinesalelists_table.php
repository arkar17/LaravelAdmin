<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLonepyinesalelistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lonepyinesalelists', function (Blueprint $table) {
            $table->id();
            $table->integer('lonepyine_id');
            $table->integer('agent_id');
            $table->bigInteger('sale_amount')->nullable();
            $table->string('status')->default(0);
            $table->boolean('winning_status')->default(0);
            $table->dateTime('datetime')->nullable();
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
        Schema::dropIfExists('lonepyinesalelists');
    }
}
