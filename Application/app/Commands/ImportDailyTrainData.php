<?php

namespace App\Commands;

use App\Gateways\DailyTrainDataGateway;
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
     * Create a new command instance.
     * @param DailyTrainDataGateway $gateway
     * @param Parser $xmlParser
     */
    public function __construct( DailyTrainDataGateway $gateway, Parser $xmlParser )
    {
        $this->gateway = $gateway;
        $this->xmlParser = $xmlParser;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $xmlData = $this->gateway->getDailyTrainData();
        $data = $this->xmlParser->xml( $xmlData );
        var_dump( $data );
        return $data;
    }
}
