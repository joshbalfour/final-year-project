<?php

namespace App\Commands;

use App\Commands\Command;
use App\Exceptions\FileNotFoundException;
use Illuminate\Contracts\Bus\SelfHandling;
use League\Flysystem\Adapter\AbstractFtpAdapter;
use League\Flysystem\Adapter\Ftp;

class ImportDailyTrainData extends Command implements SelfHandling
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

    /**
     * Execute the command.
     */
    public function handle()
    {
        $files = $this->ftpAdapter->listContents();

        foreach ( $files as $filename ){
            echo $filename."\n\r";
            if ( strpos( $filename, date( 'Ymd' ) ) !== false && strpos( $filename, '_v8.xml.gz' ) !== false ){
                $dataFile = $filename;
                break;
            }
        }

        if (empty( $dataFile )) {
            return null;
        }

        $this->ftpAdapter->connect();
        $data = $this->ftpAdapter->read( $dataFile );

        if ( empty( $data['contents'] ) ){
            return false;
        }

        return true;
    }
}
