<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 12:46
 */

namespace App\Commands;


use App\Gateways\DailyTrainDataGateway;

class MockDailyTrainDataGateway implements DailyTrainDataGateway
{

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
        return null;
    }
}