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
     */
    public function insert( $rows )
    {
        foreach($rows as $row){
            $this->data[] = $row;
        }
    }

    public function update($rows)
    {
        foreach ( $rows as $row ){
            foreach ( $this->data as $index => $oldRow ){
                if( $oldRow[0] == $row['rid'] ) {
                    if (!empty($row['wta'])) {
                        if ($oldRow[4]->toDateTimeString() == $row['wta']->toDateTimeString()) {
                            $this->data[$index][4] = $row['ta'];
                        }
                    }
                    if (!empty($row['wtd'])) {
                        if ($oldRow[2]->toDateTimeString() == $row['wtd']->toDateTimeString()) {
                            $this->data[$index][2] = $row['td'];
                        }
                    }
                    if (!empty($row['wtp'])) {
                        if ($oldRow[2]->toDateTimeString() == $row['wtp']->toDateTimeString()) {
                            $this->data[$index][2] = $row['tp'];
                        }
                        if ($oldRow[4]->toDateTimeString() == $row['wtp']->toDateTimeString() ) {
                            $this->data[$index][4] = $row['tp'];
                        }
                    }
                }
            }
        }
    }

    public function truncateToCrsTable()
    {
        // no need to Implement truncateToCrsTable() method.
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
