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
     * @var array data to be inserted
     */
    private $data;

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
        $xmlString = $this->gateway->getDailyTrainData();
        $xmlData = new \SimpleXMLElement( $xmlString );
        foreach( $xmlData->Journey as $journey ){
            $rid = (int)$journey['rid'];
            foreach( $journey->children() as $type => $stop ){
                $stationDepartureTime = false;
                if( $type == "OR" ){
                    $from = $this->getStationName( $stop );
                    $fromTime = $this->getDateTime( $stop['wtd'] );
                } else if( $type == "PP" ) {
                    $to = $this->getStationName( $stop );
                    $toTime = $this->getDateTime( $stop['wtp'] );
                } else if( $type == "IP" ) {
                    $to = $this->getStationName( $stop );
                    $toTime = $this->getDateTime( $stop['wta'] );
                    $stationDepartureTime = $this->getDateTime( $stop['wtd'] );
                } else if( $type == "DT" ){
                    $to = $this->getStationName( $stop );
                    $toTime = $this->getDateTime( $stop['wta'] );
                }

                if( isset( $from, $fromTime, $to, $toTime ) ) {
                    $this->saveDataToArrayAndUpdateFromValues( $rid, $from, $fromTime, $to, $toTime, $stationDepartureTime );
                }
            }
            unset( $from, $fromTime, $to, $toTime );
        }

        $this->trainDataStorage->insert( $this->data );
    }

    private function getStationName($stop)
    {
        return (string)$stop['tpl'];
    }

    private function saveDataToArrayAndUpdateFromValues( $rid, &$from, \DateTimeInterface &$fromTime, $to, \DateTimeInterface $toTime, $stationDepartureTime )
    {
        $this->saveToArray($rid, $from, $fromTime, $to, $toTime);
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

    private function saveToArray($rid, $from, \DateTimeInterface $fromTime, $to, \DateTimeInterface $toTime)
    {
        $this->data[] = [ 'rid' => $rid, 'from_tpl' => $from, 'from_time' => $fromTime->format( 'Y-m-d H:i:s' ), 'to_tpl' => $to, 'to_time' => $toTime->format( 'Y-m-d H:i:s' ) ];
    }
}
