<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrossingIntersectionTimeView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create view crossing_intersection_time AS select distinct
                train_route_has_crossing.crossing_id,
                train_times_with_crs.from_time,
                train_times_with_crs.to_time,
                DATE_SUB(ADDTIME(train_times_with_crs.from_time, SEC_TO_TIME((train_route_has_crossing.distance_along_track / ST_Length(train_routes.route)) * (train_times_with_crs.to_time - train_times_with_crs.from_time))), INTERVAL 2 MINUTE) AS down_time,
                DATE_ADD(ADDTIME(train_times_with_crs.from_time, SEC_TO_TIME((train_route_has_crossing.distance_along_track / ST_Length(train_routes.route)) * (train_times_with_crs.to_time - train_times_with_crs.from_time))), INTERVAL 30 SECOND) AS up_time
            from
                train_routes
            join
                train_route_has_crossing
                on
                    train_route_has_crossing.train_route_id = train_routes.id
            join
                train_times_with_crs
                on
                    train_times_with_crs.from_crs = train_routes.from
                AND
                    train_times_with_crs.to_crs = train_routes.to
            where
                hasCrossing = 1;
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
        DB::statement("drop view crossing_intersection_time;");
    }
}
