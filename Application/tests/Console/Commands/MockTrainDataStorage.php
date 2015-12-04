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
     * @param $rid
     * @param $from
     * @param \DateTimeInterface $fromTime
     * @param $to
     * @param \DateTimeInterface $toTime
     * @internal param array $trainTimes array of train times data
     */
    public function insert( $rid, $from, \DateTimeInterface $fromTime, $to, \DateTimeInterface $toTime )
    {
        $this->data[] = [ 'rid' => $rid, 'from_tpl' => $from, 'from_time' => $fromTime->format( 'Y-m-d H:i:s' ), 'to_tpl' => $to, 'to_time' => $toTime->format( 'Y-m-d H:i:s' ) ];
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

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }
}