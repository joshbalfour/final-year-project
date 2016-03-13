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

            return "( ?, ? ,? ,? ,?)";
        }, $rows);

        DB::insert( "INSERT INTO train_times ( rid, from_tpl, from_time, to_tpl, to_time) VALUES ".implode(",",$params), $flattenedRows );
    }

    

    public function update($rows)
    {   
        if (count($rows) == 0){
            return;
        }
        $queries = "";
        $values = [];
        
        foreach($rows as $row){
            
            if ($row["ta"] != null){
                $queries .= 'update train_times_with_crs set to_time = ? where rid=? and orig_to_time = ? and to_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ); ';

                array_push($values, $row["ta"], $row["rid"], $row["wta"], $row["tpl"]);
            }

            if ($row["td"] != null){
                $queries .= 'update train_times_with_crs set from_time = ? where rid=? and orig_from_time = ? and from_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ); ';
                array_push($values, $row["td"], $row["rid"], $row["wtd"], $row["tpl"]);
            }

            if ($row["tp"] != null){
                $queries .= 'update train_times_with_crs set from_time = ? where rid=? and orig_from_time = ? and from_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ); ';
                array_push($values, $row["tp"], $row["rid"], $row["wtp"], $row["tpl"]);

                $queries .= 'update train_times_with_crs set to_time = ? where rid=? and orig_to_time = ? and to_crs = ( select max(3alpha) from tiploc_to_crs where tiploc=? ); ';
                array_push($values, $row["tp"], $row["rid"], $row["wtp"], $row["tpl"]);
            }
        }
        DB::statement($queries, $values);
    }


    public function beginTransaction()
    {
        DB::beginTransaction();
        DB::connection()->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
    }

    public function commit()
    {
        DB::commit();
    }
}
