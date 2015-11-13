<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 12/11/15
 * Time: 11:54
 */

namespace App\Gateways;

use League\Flysystem\Adapter\AbstractFtpAdapter;

class DailyTrainDataFtpGateway implements DailyTrainDataGateway
{

    /**
     * @var AbstractFtpAdapter
     */
    private $ftpAdapter;

    /**
     * Create a new command instance.
     * @param AbstractFtpAdapter $ftpAdapter
     */
    public function __construct( AbstractFtpAdapter $ftpAdapter )
    {
        $this->ftpAdapter = $ftpAdapter;
    }

    public function getDailyTrainData()
    {
        $files = $this->ftpAdapter->listContents();
        $file = $this->getCorrectFileFromListOfFiles($files);
        if (empty( $file )) {
            return null;
        }
        return $this->getXMLDataAsStringFromFile($file);
    }

    /**
     * @param $files
     * @return string
     */
    private function getCorrectFileFromListOfFiles($files)
    {
        $dataFile = '';
        foreach ($files as $file) {
            if (strpos($file['path'], date('Ymd')) !== false && strpos($file['path'], '_v8.xml.gz') !== false) {
                $dataFile = $file['path'];
                break;
            }
        }
        return $dataFile;
    }

    /**
     * @param $file
     * @return string
     */
    private function getXMLDataAsStringFromFile($file)
    {
        $data = $this->getCompressedDataFromFTPServer($file);
        if ( empty( $data['contents'] ) ){
            return false;
        }
        return gzdecode( $data['contents'] );
    }

    /**
     * @param $file
     * @return array
     */
    private function getCompressedDataFromFTPServer($file)
    {
        $this->ftpAdapter->connect();
        $data = $this->ftpAdapter->read($file);
        $this->ftpAdapter->disconnect();
        return $data;
    }
}