<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FuckMysqlRoyally extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("rename table train_times_with_crs to x_train_times_with_crs");
        DB::statement("create index idx_train_times_rid on train_times (rid)");

        DB::statement(file_get_contents("/src/database/data/flat_train_times_with_crs.sql"));
        
        DB::statement("create table train_times_with_crs as select * from v_train_times_with_crs");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('train_times_with_crs');
        Schema::drop('v_train_times_with_crs');
        DB::statement("rename table x_train_times_with_crs to train_times_with_crs");
        DB::statement("alter table train_times drop index idx_train_times_rid");
    }
}
