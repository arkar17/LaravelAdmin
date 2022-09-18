<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefereesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referees', function (Blueprint $table) {
            $table->id();
            // $table->foreign('guest_id')->references('id')->on('guests');
            // $table->foreign('operationstaff_id')->references('id')->on('operationstaffs');
            $table->integer('user_id');
            $table->integer('operationstaff_id');
            $table->integer('role_id');
            $table->string('referee_code')->nullable();
            $table->string('remark')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('main_cash')->nullable();
            $table->string('avaliable_date')->nullable();
            $table->integer('active_status')->nullable();
            $table->boolean('is_online')->default(0);
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
        Schema::dropIfExists('referees');
    }
}
