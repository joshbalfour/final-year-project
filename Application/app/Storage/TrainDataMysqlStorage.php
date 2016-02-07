<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 13/11/15
 * Time: 14:51
 */

namespace App\Storage;

use Illuminate\Support\Facades\DB;

class TrainDataMysqlStorage implements TrainDataStorage
{
    /**
     * @param $rows Array of rows
     * @return
     * @internal param array $trainTimes array of train times data
     */
    public function insert($rows)
    {
        $flattenedRows = [];
        
        $params = array_map(function($row) use (&$flattenedRows) {
            foreach ($row as $value){
                $flattenedRows[] = $value;
            }
            return "( ?, ? ,? ,? ,? )";
        }, $rows);

        DB::insert( "INSERT INTO train_times ( rid, from_tpl, from_time, to_tpl, to_time ) VALUES ".implode(",",$params), $flattenedRows );
    }

    

    public function update($rows)
    {   
        foreach($rows as $row){
            // todo: batch this using insert code
            $values = [
                $row["rid"],
                $row["tpl"],
                $row["ta"],
                $row["td"],
                $row["tp"],
                $row["wta"],
                $row["wtd"],
                $row["wtp"],
                $row["ts"]
            ];

            DB::statement('replace into rt_updates(`rid`, `tpl`, `ta`,`td`,`tp`, `wta`,`wtd`,`wtp`,`ts`) values(?,?,?,?,?,?,?,?,?)', $values);
        }
    }


    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    public function commit()
    {
        DB::commit();
    }
}
