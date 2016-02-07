<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 11:54
 */

namespace App\Gateways;

interface RTTrainDataGateway
{
    /**
     * @return string
     */
    public function getRTTrainData($limit, $output);
}
