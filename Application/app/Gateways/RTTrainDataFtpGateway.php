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

    public function getRTTrainData($limit, $output)
    {

        $ftpContents = $this->ftpAdapter->listContents();
        $ftpFilePaths = $this->getCorrectFilesFromListOfFiles($ftpContents);

        if (count( $ftpFilePaths ) == 0) {
            throw new \Exception('Not realtime data on ftp');
        }

        if (!$limit){
            $limit = count($ftpFilePaths);
        }

        if ($output){
            $bar = $output->createProgressBar($limit);
        }

        $filePaths = [];
        
        $bar->start();

        foreach ($ftpFilePaths as $ftpFilePath){
           if (Cache::has($ftpFilePath)) {
                if ($bar){
                    $bar->advance();
                }
           } else {
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
                    if ($bar){
                        $bar->advance();
                    }
               }
           }
        }

        if ($bar){
            $bar->finish();
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
        return $data['contents'];
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
}
