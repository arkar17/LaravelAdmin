<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('team_one_id');
            $table->integer('team_two_id');
            $table->integer('tournament_id');
            $table->string('match_type');
            $table->date('date');
            $table->time('time');
            $table->integer('team_one_compensation')->nullable();
            $table->integer('team_two_compensation')->nullable();
            $table->integer('draw_compensation')->nullable();
            $table->integer('two_zero_compensation')->nullable();
            $table->integer('zero_two_compensation')->nullable();
            $table->integer('two_one_compensation')->nullable();
            $table->integer('one_two_compensation')->nullable();
            $table->integer('three_zero_compensation')->nullable();
            $table->integer('zero_three_compensation')->nullable();
            $table->integer('three_two_compensation')->nullable();
            $table->integer('two_three_compensation')->nullable();
            $table->integer('over_two_five')->nullable();
            $table->integer('under_two_five')->nullable();
            $table->integer('over_three_five')->nullable();
            $table->integer('under_three_five')->nullable();
            $table->integer('over_four_five')->nullable();
            $table->integer('under_four_five')->nullable();

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
        Schema::dropIfExists('matches');
    }
}
