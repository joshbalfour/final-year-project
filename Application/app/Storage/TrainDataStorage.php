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
     * @param $rows
     */
    public function insert( $rows );

    /**
     * @param $rows
     */
    public function update($rows );
}
