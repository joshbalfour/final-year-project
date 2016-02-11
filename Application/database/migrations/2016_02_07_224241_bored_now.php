<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class BoredNow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('rt_updates', function (Blueprint $table) {
            $table->bigInteger('rid');
            $table->dateTime('ts');
            $table->string('tpl');
            
            $table->dateTime('ta')->nullable();
            $table->dateTime('td')->nullable();
            $table->dateTime('tp')->nullable();

            $table->dateTime('wta')->nullable();
            $table->dateTime('wtd')->nullable();
            $table->dateTime('wtp')->nullable();
        });

        DB::statement("ALTER TABLE `rt_updates` ADD UNIQUE INDEX `idx_rt_updates` (`rid` ASC, `ts` ASC);");

        DB::statement("alter table `train_times` add orig_from_time datetime not null, add orig_to_time datetime not null");

        DB::statement("
            create or replace view v_train_times_with_crs AS select
                from_crs.3alpha as from_crs,
                to_crs.3alpha as to_crs,
                train_times.from_time,
                train_times.to_time,
                train_times.rid,
                train_times.orig_to_time,
                train_times.orig_from_time
            from
                train_times
            join
                tiploc_to_crs as to_crs
                on
                    to_crs.tiploc = train_times.to_tpl
            join
                tiploc_to_crs as from_crs
                on
                    from_crs.tiploc = train_times.from_tpl;
        ");

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
        Schema::drop('rt_updates');
        DB::statement("alter table `train_times` drop orig_from_time, drop orig_to_time");
        DB::statement("alter table `train_times_with_crs` drop orig_from_time, drop orig_to_time");
        DB::statement("
            create or replace view v_train_times_with_crs AS select
                from_crs.3alpha as from_crs,
                to_crs.3alpha as to_crs,
                train_times.from_time,
                train_times.to_time,
                train_times.rid
            from
                train_times
            join
                tiploc_to_crs as to_crs
                on
                    to_crs.tiploc = train_times.to_tpl
            join
                tiploc_to_crs as from_crs
                on
                    from_crs.tiploc = train_times.from_tpl;
        ");
    }
}
