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
     * @param $rows array of rows
     */
    public function insert($rows)
    {
        $flattenedRows = [];
        
        $params = array_map(function($row) use (&$flattenedRows) {
            foreach ($row as $value){
                $flattenedRows[] = $value;
            }
            
            $flattenedRows[] = $row[2];
            $flattenedRows[] = $row[4];

            return "( ?, ? ,? ,? ,?, ?, ? )";
        }, $rows);

        DB::insert( "INSERT INTO train_times ( rid, from_tpl, from_time, to_tpl, to_time, orig_from_time, orig_to_time) VALUES ".implode(",",$params), $flattenedRows );
    }

    

    public function update($rows)
    {   
        
        foreach($rows as $row){
           
            // todo: batch this
            
            if ($row["ta"] != null){
                $query = 'update train_times_with_crs set to_time = ? where rid=? and orig_to_time = ? and to_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ) ';
                $values = [$row["ta"], $row["rid"], $row["wta"], $row["tpl"]];
                DB::statement($query, $values);
            }

            if ($row["td"] != null){
                $query = 'update train_times_with_crs set from_time = ? where rid=? and orig_from_time = ? and from_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ) ';
                $values = [$row["td"], $row["rid"], $row["wtd"], $row["tpl"]];
                DB::statement($query, $values);
            }

            if ($row["tp"] != null){
                $query = 'update train_times_with_crs set from_time = ? where rid=? and orig_from_time = ? and from_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ) ';
                $values = [$row["ta"], $row["rid"], $row["wta"], $row["tpl"]];
                DB::statement($query, $values);

                $query = 'update train_times_with_crs set to_time = ? where rid=? and orig_to_time = ? and to_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ) ';
                $values = [$row["td"], $row["rid"], $row["wtd"], $row["tpl"]];
                DB::statement($query, $values);
            }

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
