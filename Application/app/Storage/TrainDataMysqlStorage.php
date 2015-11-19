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
     * @param array $trainTimes array of train times data
     */
    public function insert($trainTimes)
    {
        DB::table('train_times')->insert( $trainTimes );
    }
}