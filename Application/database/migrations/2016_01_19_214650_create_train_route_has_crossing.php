<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainRouteHasCrossing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE `train_route_has_crossing` (
                `train_route_id` int(11) DEFAULT NULL,
                `crossing_id` int(11) DEFAULT NULL,
                `distance_along_track` double DEFAULT NULL COMMENT 'Distance it lat long points, not miles',
                `node_number` int(11) DEFAULT NULL,
                KEY `train_route_id` (`train_route_id`),
                KEY `crossing_id` (`crossing_id`)
            ) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;
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
        Schema::drop('train_route_has_crossing');
    }
}
