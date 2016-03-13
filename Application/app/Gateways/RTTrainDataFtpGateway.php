<?php

namespace App\Gateways;

use League\Flysystem\Adapter\AbstractFtpAdapter;
use Cache;

class RTTrainDataFtpGateway implements RTTrainDataGateway
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

    public function getRTTrainData()
    {

        $ftpContents = $this->ftpAdapter->listContents();
        $ftpFilePath = $this->getCorrectFileFromListOfFiles($ftpContents);

        return $this->getXMLDataAsStringFromFile($ftpFilePath);
    }

    /**
     * @param $files
     * @return string
     * @throws \Exception
     */
    private function getCorrectFileFromListOfFiles($files)
    {
        foreach ($files as $file) {
            if (strpos($file['path'], 'pPortData.log') !== false) {
                return $file['path'];
            }
        }

        throw new \Exception("Real Time data file not found");
    }

    /**
     * @param $file
     * @return string
     */
    private function getXMLDataAsStringFromFile($file)
    {
        $data = $this->getDataFromFTPServer($file);
        if ( empty( $data['contents'] ) ){
            return false;
        }
        return $this->stripMalformedFileEnding( $data['contents'] );
    }

    /**
     * @param $file
     * @return array
     */
    private function getDataFromFTPServer($file)
    {
        $this->ftpAdapter->connect();
        $data = $this->ftpAdapter->read($file);
        $this->ftpAdapter->disconnect();
        return $data;
    }

    /**
     * pPortData.log seems to be constantly updating, when downloaded you get malformed xml at the end
     * this gets rid of that
     *
     * @param $contents
     * @return string
     */
    private function stripMalformedFileEnding( $contents )
    {
        $endString = "</Pport>";
        $endStringPos = strrpos($contents, $endString);
        if( $endStringPos == 0 ) {
           return $contents;
        }

        return substr( $contents, 0, $endStringPos +strlen($endString) );
    }
}
