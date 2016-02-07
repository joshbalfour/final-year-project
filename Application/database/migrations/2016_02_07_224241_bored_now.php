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
    }
}
