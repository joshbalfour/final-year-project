<?php

namespace App\Commands;

use App\Gateways\DailyTrainDataGateway;
use Illuminate\Contracts\Bus\SelfHandling;

class ImportDailyTrainData extends Command implements SelfHandling
{
    /**
     * @var DailyTrainDataGateway
     */
    private $gateway;

    /**
     * Create a new command instance.
     * @param DailyTrainDataGateway $gateway
     */
    public function __construct( DailyTrainDataGateway $gateway )
    {
        $this->gateway = $gateway;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $data = $this->gateway->getDailyTrainData();
    }
}
