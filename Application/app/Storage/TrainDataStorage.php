<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 14:50
 */

namespace App\Storage;


interface TrainDataStorage
{
    public function beginTransaction();

    public function commit();

    /**
     * @param $rid
     * @param $from
     * @param \DateTimeInterface $fromTime
     * @param $to
     * @param \DateTimeInterface $toTime
     * @return
     * @internal param array $trainTimes array of train times data
     */
    public function insert( $whyDoesThisExist );

    public function update( $reallyJustWhy );
}
