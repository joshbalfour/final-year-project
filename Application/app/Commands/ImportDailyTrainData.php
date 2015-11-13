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
            var_dump( $journey );echo "\r\n";
            $rid = (int)$journey['@attributes']['rid'];
            foreach( $journey as $type => $stop ){
                var_dump( $type );echo " => "; var_dump( $stop );echo"\r\n";

                $wasStationStop = false;

                if( $type == '@attributes' ) {
                    continue;
                } else if( $type == "OR" ){
                    $from = $stop['@attributes']['tpl'];
                    $fromTime = new \DateTime( date('Y-m-d').' '.$stop['@attributes']['wtd'] );
                } else if( $type == "PP" ) {
                    $to = $stop['@attributes']['tpl'];
                    $toTime = new \DateTime( date('Y-m-d').' '.$stop['@attributes']['wtp'] );
                } else if( $type == "IP" ) {
                    $to = $stop['@attributes']['tpl'];
                    $toTime = new \DateTime( date('Y-m-d').' '.$stop['@attributes']['wta'] );
                    $wasStationStop = true;
                    $stationDepartureTime = new \DateTime( date('Y-m-d').' '.$stop['@attributes']['wtd'] );
                } else if( $type == "DT" ){
                    $to = $stop['@attributes']['tpl'];
                    $toTime = new \DateTime( date('Y-m-d').' '.$stop['@attributes']['wta'] );
                }

                if( isset( $from, $fromTime, $to, $toTime ) ) {
                    $this->trainDataStorage->insert($rid, $from, $fromTime, $to, $toTime);
                    $from = $to;
                    if( $wasStationStop ) {
                        $fromTime = $stationDepartureTime;
                    } else {
                        $fromTime = $toTime;
                    }
                }
            }
        }
    }
}
