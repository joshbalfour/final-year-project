<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrossingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("create table crossings (
            id integer,
            crossing_name varchar(255),
            crossing_type varchar(255),
            loc point not null, spatial index(loc),

            postcode varchar(255),
            city varchar(255),

            types_of_trains varchar(255),
            line_speed varchar(255),
            no_of_trains varchar(255)
            )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("drop table crossings;");
    }
}
