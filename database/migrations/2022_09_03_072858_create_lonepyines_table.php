<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLonepyinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lonepyines', function (Blueprint $table) {
            $table->id();
            $table->integer('referee_id');
            $table->string('number')->nullable();
            $table->bigInteger('max_amount')->nullable();
            $table->integer('compensation')->nullable();
            $table->date('date')->nullable();
            $table->string('round')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('lonepyines');
    }
}
