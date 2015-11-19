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
     * @param array $trainTimes array of train times data
     */
    public function insert( $trainTimes );

}