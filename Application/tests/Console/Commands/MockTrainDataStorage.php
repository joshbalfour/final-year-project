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
     * @param $rows array of Rows
     * @internal param array $trainTimes array of train times data
     */
    public function insert( $rows )
    {
        $this->data = $rows;
    }

    public function update($rows)
    {
        //implement updating the rows
    }

    public function beginTransaction()
    {
        //not needed in the mock but like... this shouldn't be here in that case
    }

    public function commit()
    {
        //same
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
