<?php
/**
 * Storage class that never does anything to speed up integrating with the ftp server
 *
 * Created by PhpStorm.
 * User: ryan
 * Date: 10/03/16
 * Time: 14:46
 */

namespace App\Storage;


class NullTrainDataStorage implements TrainDataStorage
{

    public function beginTransaction()
    {
        // null
    }

    public function commit()
    {
        // null
    }

    /**
     * @param $rows
     */
    public function insert($rows)
    {
        // null
    }

    /**
     * @param $rows
     */
    public function update($rows)
    {
        // null
    }

    public function truncateToCrsTable()
    {
        // null
    }
}