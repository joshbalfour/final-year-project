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
        DB::statement("create index rid on train_times_with_crs(rid);");
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
        DB::statement("DROP INDEX rid ON train_times_with_crs;");
    }
}
