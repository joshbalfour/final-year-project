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

    /**
     * @param $rid
     * @param $from
     * @param \DateTimeInterface $fromTime
     * @param $to
     * @param \DateTimeInterface $toTime
     */
    public function insert( $rid, $from, \DateTimeInterface $fromTime, $to, \DateTimeInterface $toTime );

}