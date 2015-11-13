<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTrainTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_tpl');
            $table->dateTime('from_time');
            $table->string('to_tpl');
            $table->dateTime('to_time');
            $table->integer( 'rid' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('train_times');
    }
}
