<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 19/02/16
 * Time: 14:37
 */

namespace App\Console\Commands;


use App\Gateways\RTTrainDataGateway;

class MockRTTrainDataGateway implements RTTrainDataGateway
{
    private $data;

    /**
     * MockRTTrainDataGateway constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getRTTrainData($really, $hatePhp)
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
