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
     * @param $rid
     * @param $from
     * @param \DateTimeInterface $fromTime
     * @param $to
     * @param \DateTimeInterface $toTime
     */
    public function insert($rid, $from, \DateTimeInterface $fromTime, $to, \DateTimeInterface $toTime)
    {
        DB::insert( 'insert into train_times ( from_tpl, from_time, to_tpl, to_time, rid ) values ( ?, ?, ?, ?, ? )',
            [ $from, $fromTime->format('Y-m-d H:i:s'), $to, $toTime->format('Y-m-d H:i:s'), $rid] );
    }
}