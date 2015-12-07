<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TiplocToCrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiploc_to_crs', function (Blueprint $table) {
            $table->string("STANOX");
            $table->string("UIC");
            $table->string("3ALPHA");
            $table->string("NLCDESC16");
            $table->string("TIPLOC");
            $table->string("NLC");
            $table->string("NLCDESC");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tiploc_to_crs');
    }
}
