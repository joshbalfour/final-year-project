<?php

namespace App\Console\Commands;

use App\Gateways\DailyTrainDataGateway;
use App\Storage\TrainDataStorage;
use Illuminate\Console\Command;
use Carbon\Carbon;
// use Illuminate\Console\OutputStyle;

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
    public function __construct( DailyTrainDataGateway $gateway, TrainDataStorage $trainDataStorage/*, OutputStyle $output*/)
    {
        parent::__construct();
        $this->gateway = $gateway;
        $this->trainDataStorage = $trainDataStorage;
        //$this->output = $output;
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
        echo \App::environment();
        if (\App::environment() != "testing"){
            // guestimate - allows us to show progress and a rough percentage
            $bar = $this->output->createProgressBar(900000);
            $bar->setRedrawFrequency(5000);
            $bar->setFormat('very_verbose');
        }

        $this->trainDataStorage->beginTransaction();

        $onekrows = [];

        while( $reader->read() ){
            if( $reader->name == "Journey" ) {
                $journey = new \SimpleXMLElement($reader->readOuterXml());
                $rid = (int)$journey['rid'];
                
                $rollingDate = new Carbon($journey["ssd"]);
                $prevRollingDate = $rollingDate->copy();

                foreach ($journey->children() as $type => $stop) {
                    
                    $stationDepartureTime = false;

                    if ($type == "OR") {
                        $from = $this->getStationName($stop);
                        $fromTime = $this->getDateTime($rollingDate, $stop['wtd'], $prevRollingDate);
                    } else if ($type == "PP") {
                        $to = $this->getStationName($stop);
                        $toTime = $this->getDateTime($rollingDate, $stop['wtp'], $prevRollingDate);
                    } else if ($type == "IP") {
                        $to = $this->getStationName($stop);
                        $toTime = $this->getDateTime($rollingDate, $stop['wta'], $prevRollingDate);
                        $stationDepartureTime = $this->getDateTime($rollingDate, $stop['wtd'], $prevRollingDate);
                    } else if ($type == "DT") {
                        $to = $this->getStationName($stop);
                        $toTime = $this->getDateTime($rollingDate, $stop['wta'], $prevRollingDate);
                    }

                    if (isset($from, $fromTime, $to, $toTime)) {
                        $this->updateStartingLocationAndTimeForNextSectionOfTrack( $from, $fromTime, $to, $toTime, $stationDepartureTime );
                        $onekrows[] = [$rid, $from, $fromTime, $to, $toTime];
                    }

                    $prevRollingDate = $rollingDate->copy();
                }
                unset($from, $fromTime, $to, $toTime);
            }

            if (count($onekrows) > 5000){
                
                $this->insertDataToDatabaseAndUpdateFromValues($onekrows);
                
                $onekrows = [];

                if (\App::environment() != "testing"){
                    $bar->advance(5000);
                }
            }
        }
        
        $this->insertDataToDatabaseAndUpdateFromValues($onekrows);

        echo "\nImported Train Times.\n";
        $this->trainDataStorage->commit();
        


        if (\App::environment() != "testing"){
            $bar->finish();
        }
    }

    private function getStationName($stop)
    {
        return (string)$stop['tpl'];
    }

    private function insertDataToDatabaseAndUpdateFromValues($rows )
    {
        $this->trainDataStorage->insert( $rows );
    }

    private function updateStartingLocationAndTimeForNextSectionOfTrack( &$from, &$fromTime, $to, $toTime, $stationDepartureTime )
    {
        $from = $to;
        if( $stationDepartureTime ) {
            $fromTime = $stationDepartureTime->copy();
        } else {
            $fromTime = $toTime->copy();
        }
    }

    private function getDateTime( &$date, $time, &$prevRollingDate )
    {
        list($hour, $minute, $second) = explode(':', $time . ":00");
        if (empty($second)){
            $second = 0; // no idea if this'll do anything or not
        }
        $date->setTime($hour, $minute, $second);
        
        if ($prevRollingDate->gte($date)){
            $date->addDay(1);
        }

        return $date->copy();
    }
}
