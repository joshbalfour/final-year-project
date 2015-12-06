<?php

namespace App\Console\Commands;

use App\Gateways\DailyTrainDataGateway;
use App\Storage\TrainDataStorage;
use Illuminate\Console\Command;

class ImportDailyTrainData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:daily-train-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads and imports the daily train time data from the national rail ftp server';

    /**
     * @var DailyTrainDataGateway
     */
    private $gateway;

    /**
     * @var TrainDataStorage
     */
    private $trainDataStorage;

    /**
     * Create a new command instance.
     * @param DailyTrainDataGateway $gateway
     * @param TrainDataStorage $trainDataStorage
     */
    public function __construct( DailyTrainDataGateway $gateway, TrainDataStorage $trainDataStorage )
    {
        parent::__construct();
        $this->gateway = $gateway;
        $this->trainDataStorage = $trainDataStorage;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        echo "\nDownloading Train Times.\n";
        $filePath = $this->gateway->getDailyTrainData();
        $reader = new \XMLReader();
        if(!$reader->open($filePath)){
            throw new \Exception( "Failed to open file" );
        }
        echo "\nDownloaded Train Times.\n";
        echo "\nImporting Train Times.\n";
        // guestimate - allows us to show progress and a rough percentage
        $bar = $this->output->createProgressBar(700000);
        $bar->setFormat('very_verbose');
        $this->trainDataStorage->beginTransaction();

        while( $reader->read() ){
            if( $reader->name == "Journey" ) {
                $journey = new \SimpleXMLElement($reader->readOuterXml());
                $rid = (int)$journey['rid'];
                foreach ($journey->children() as $type => $stop) {
                    $stationDepartureTime = false;
                    if ($type == "OR") {
                        $from = $this->getStationName($stop);
                        $fromTime = $this->getDateTime($stop['wtd']);
                    } else if ($type == "PP") {
                        $to = $this->getStationName($stop);
                        $toTime = $this->getDateTime($stop['wtp']);
                    } else if ($type == "IP") {
                        $to = $this->getStationName($stop);
                        $toTime = $this->getDateTime($stop['wta']);
                        $stationDepartureTime = $this->getDateTime($stop['wtd']);
                    } else if ($type == "DT") {
                        $to = $this->getStationName($stop);
                        $toTime = $this->getDateTime($stop['wta']);
                    }

                    if (isset($from, $fromTime, $to, $toTime)) {
                        $this->insertDataToDatabaseAndUpdateFromValues($rid, $from, $fromTime, $to, $toTime, $stationDepartureTime);
                        $bar->advance(1);
                    }
                }
                unset($from, $fromTime, $to, $toTime);
            }
        }
        echo "\nImported Train Times.\n";
        $this->trainDataStorage->commit();
        $bar->finish();
    }

    private function getStationName($stop)
    {
        return (string)$stop['tpl'];
    }

    private function insertDataToDatabaseAndUpdateFromValues($rid, &$from, \DateTimeInterface &$fromTime, $to, \DateTimeInterface $toTime, $stationDepartureTime )
    {
        $this->trainDataStorage->insert( $rid, $from, $fromTime, $to, $toTime );
        $this->updateStartingLocationAndTimeForNextSectionOfTrack( $from, $fromTime, $to, $toTime, $stationDepartureTime );
    }

    private function updateStartingLocationAndTimeForNextSectionOfTrack( &$from, &$fromTime, $to, $toTime, $stationDepartureTime )
    {
        $from = $to;
        if( $stationDepartureTime ) {
            $fromTime = $stationDepartureTime;
        } else {
            $fromTime = $toTime;
        }
    }

    private function getDateTime( $time )
    {
        return new \DateTime( date('Y-m-d').' '.$time );
    }
}
