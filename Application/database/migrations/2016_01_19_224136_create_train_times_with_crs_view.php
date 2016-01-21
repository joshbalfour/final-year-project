<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainTimesWithCrsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create view train_times_with_crs AS select
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
                    from_crs.tiploc = train_times.from_tpl
            WHERE 
                `from_crs`.`3ALPHA` != NULL
            AND 
                `to_crs`.`3ALPHA` != NULL;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("drop view train_times_with_crs;");
    }
}
