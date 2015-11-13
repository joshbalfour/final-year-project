<?php

namespace App\Commands;

use App\Gateways\DailyTrainDataGateway;
use App\Storage\TrainDataStorage;
use Illuminate\Contracts\Bus\SelfHandling;
use Nathanmac\Utilities\Parser\Parser;

class ImportDailyTrainData extends Command implements SelfHandling
{
    /**
     * @var DailyTrainDataGateway
     */
    private $gateway;

    /**
     * @var Parser
     */
    private $xmlParser;
    /**
     * @var TrainDataStorage
     */
    private $trainDataStorage;

    /**
     * Create a new command instance.
     * @param DailyTrainDataGateway $gateway
     * @param Parser $xmlParser
     * @param TrainDataStorage $trainDataStorage
     */
    public function __construct( DailyTrainDataGateway $gateway, Parser $xmlParser, TrainDataStorage $trainDataStorage )
    {
        $this->gateway = $gateway;
        $this->xmlParser = $xmlParser;
        $this->trainDataStorage = $trainDataStorage;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $xmlData = $this->gateway->getDailyTrainData();
        $journeys = $this->xmlParser->xml( $xmlData );

        foreach ( $journeys as $journey ){
            $rid = (int)$journey['@attributes']['rid'];
            $stationDepartureTime = false;
            foreach( $journey as $type => $stop ){
                if( $type == '@attributes' ) {
                    //not a station stop so skip
                    continue;
                } else if( $type == "OR" ){
                    $from = $this->getStationName( $stop );
                    $fromTime = $this->getDateTime( $stop['@attributes']['wtd'] );
                } else if( $type == "PP" ) {
                    $to = $this->getStationName( $stop );
                    $toTime = $this->getDateTime( $stop['@attributes']['wtp'] );
                } else if( $type == "IP" ) {
                    $to = $this->getStationName( $stop );
                    $toTime = $this->getDateTime( $stop['@attributes']['wta'] );
                    $stationDepartureTime = $this->getDateTime( $stop['@attributes']['wtd'] );
                } else if( $type == "DT" ){
                    $to = $this->getStationName( $stop );
                    $toTime = $this->getDateTime( $stop['@attributes']['wta'] );
                }

                if( isset( $from, $fromTime, $to, $toTime ) ) {
                    $this->insertDataAndUpdateFromValues( $rid, $from, $fromTime, $to, $toTime, $stationDepartureTime );
                }
            }
        }
    }

    private function getStationName($stop)
    {
        return $stop['@attributes']['tpl'];
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
