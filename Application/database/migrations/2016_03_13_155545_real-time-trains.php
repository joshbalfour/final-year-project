<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RealTimeTrains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("alter table `train_times_with_crs` add orig_from_time datetime not null, add orig_to_time datetime not null");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("alter table `train_times_with_crs` drop orig_from_time, drop orig_to_time");
    }
}
