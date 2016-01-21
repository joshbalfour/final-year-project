<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexEverything extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        DB::statement("create index tpl on train_times(from_tpl, to_tpl);");
        DB::statement("create index from_time on train_times(from_time);");
        DB::statement("create index to_time on train_times(to_time);");
        DB::statement("create index tpl_to_crs on tiploc_to_crs(TIPLOC, 3ALPHA);");
        DB::statement("create index 3ALPHA on tiploc_to_crs(3ALPHA);");
        DB::statement("create index crossing_id on crossings(id);");
        
        DB::statement("ALTER TABLE train_routes add column id INT NOT NULL AUTO_INCREMENT FIRST, ADD primary KEY id(id);");
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::beginTransaction();
        DB::statement("DROP INDEX tpl ON train_times;");
        DB::statement("DROP INDEX from_time ON train_times;");
        DB::statement("DROP INDEX to_time ON train_times;");
        DB::statement("DROP INDEX tpl_to_crs ON tiploc_to_crs;");
        DB::statement("DROP INDEX 3ALPHA ON tiploc_to_crs;");
        DB::statement("DROP INDEX crossing_id ON crossings;");
        DB::statement("alter table train_routes drop column id;");
        DB::commit();

    }
}
