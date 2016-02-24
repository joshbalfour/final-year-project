<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 11:54
 */

namespace App\Gateways;

interface DailyTrainDataGateway
{
    /**
     * @return string
     */
    public function getDailyTrainData();
}
