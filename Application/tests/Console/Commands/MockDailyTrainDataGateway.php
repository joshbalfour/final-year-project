<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 12:46
 */

namespace App\Console\Commands;


use App\Gateways\DailyTrainDataGateway;

class MockDailyTrainDataGateway implements DailyTrainDataGateway
{
    /**
     * @var string
     */
    private $data;

    /**
     * MockDailyTrainDataGateway constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getDailyTrainData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}