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
        return null;
    }
}
