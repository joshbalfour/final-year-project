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
     * @return string
     */
    public function getDailyTrainData()
    {
        $filePath = realpath(null) . "/trainTimesTestData.xml";
        if ( file_exists( $filePath ) ){
            unlink( $filePath );
        }
        file_put_contents( $filePath, $this->data );
        return $filePath;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}