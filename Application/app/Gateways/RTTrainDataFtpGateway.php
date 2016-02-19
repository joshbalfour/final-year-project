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

    public function getRTTrainData($limit)
    {

        $ftpContents = $this->ftpAdapter->listContents();
        $ftpFilePaths = $this->getCorrectFilesFromListOfFiles($ftpContents);

        if (count( $ftpFilePaths ) == 0) {
            throw new \Exception('Not realtime data on ftp');
        }

        if (!$limit){
            $limit = count($ftpFilePaths);
        }

        $filePaths = [];

        foreach ($ftpFilePaths as $ftpFilePath){
               if (count($filePaths) < $limit){
                
                    $filePath = "/tmp/$ftpFilePath";
                    if ( file_exists( $filePath ) ){
                        unlink( $filePath );
                    }
                    file_put_contents($filePath, $this->getXMLDataAsStringFromFile($ftpFilePath));
                    
                    if (!ends_with($ftpFilePath, 'pPortData.log')) {
                        Cache::forever($ftpFilePath, true);
                    }

                    $filePaths[] = $filePath;
               }
        }

        return $filePaths;
    }

    /**
     * @param $files
     * @return string
     */
    private function getCorrectFilesFromListOfFiles($files)
    {
        $dataFiles = [];
        foreach ($files as $file) {
            if (strpos($file['path'], 'pPortData.log') !== false) {
                $dataFiles[] = $file['path'];
            }
        }
        return $dataFiles;
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
