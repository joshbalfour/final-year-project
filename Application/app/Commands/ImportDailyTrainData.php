<?php

namespace App\Commands;

use App\Gateways\DailyTrainDataGateway;
use App\Storage\TrainDataStorage;
use Illuminate\Contracts\Bus\SelfHandling;

class ImportDailyTrainData extends Command implements SelfHandling
{
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
                    $this->insertDataAndUpdateFromValues( $rid, $from, $fromTime, $to, $toTime, $stationDepartureTime );
                }
            }
            unset( $from, $fromTime, $to, $toTime );
        }
    }

    private function getStationName($stop)
    {
        return (string)$stop['tpl'];
    }

    private function insertDataAndUpdateFromValues( $rid, &$from, &$fromTime, $to, $toTime, $stationDepartureTime )
    {
        $this->trainDataStorage->insert($rid, $from, $fromTime, $to, $toTime);
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
