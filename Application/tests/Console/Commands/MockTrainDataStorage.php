<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 15:08
 */

namespace App\Console\Commands;


use App\Storage\TrainDataStorage;

class MockTrainDataStorage implements TrainDataStorage
{
    private $data;

    /**
     * MockTrainDataStorage constructor.
     * @param $data
     */
    public function __construct( $data = array() )
    {
        $this->data = $data;
    }

    /**
     * @param array $trainTimes
     */
    public function insert( $trainTimes )
    {
        $this->data = $trainTimes;
    }

    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}