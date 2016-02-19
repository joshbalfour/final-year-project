<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Gateways\RTTrainDataGateway;
use App\Storage\TrainDataStorage;
use Carbon\Carbon;
use Mockery\CountValidator\Exception;

class ImportRTTrains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:train-rt-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the real time train data';

    /**
     * @var RTTrainDataGateway
     */
    private $gateway;

    /**
     * @var TrainDataStorage
     */
    private $trainDataStorage;

    /**
     * Create a new command instance.
     * @param RTTrainDataGateway $gateway
     * @param TrainDataStorage $trainDataStorage
     */
    public function __construct( RTTrainDataGateway $gateway, TrainDataStorage $trainDataStorage)
    {
        parent::__construct();
        $this->gateway = $gateway;
        $this->trainDataStorage = $trainDataStorage;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // \DB::statement("truncate table rt_updates");
        echo "\nDownloading Realtime Train Times.\n";
        
        $file = $this->gateway->getRTTrainData();

        if( empty($file) ){
            throw new Exception( "No real time train data in file" );
        }

        $this->dealWithFile($file);
    }

    private function dealWithFile($fileContents){
        $xmlLines = explode("\n", $fileContents);

        foreach($xmlLines as $xmlLine){
                $this->dealWithPPMessage($xmlLine);
        }
    }

    private function dealWithPPMessage($ppMessageString)
    {
        $ppMessageObject = $this->convertPPMessageStringToObject($ppMessageString);
        $this->dealWithPPMessageObject($ppMessageObject);
    }


    /**
     * @param $ppMessageString
     * @return \XMLReader
     * @throws \Exception
     */
    private function convertPPMessageStringToObject($ppMessageString)
    {
        $xmlData = new \XMLReader();
        $xmlData->xml($ppMessageString);
        try{
            $xmlData->read();
        } catch (\Exception $e){
            throw new \Exception("Corrupt or Invalid XML");
        }
        return $xmlData;
    }

    /**
     * @param \XMLReader $ppMessageObject
     */
    private function dealWithPPMessageObject($ppMessageObject){
        $this->trainDataStorage->beginTransaction();
        
        $updates = [];

        while($ppMessageObject->read()){

            if($ppMessageObject->name == 'Location'){

                $update = [
                    "rid" => $ppMessageObject->getAttribute('rid'),
                    "tpl" => $ppMessageObject->getAttribute('tpl'),
                ];

                $ssd = new Carbon( $ppMessageObject->getAttribute('ssd') );

                $location = new \SimpleXMLElement( $ppMessageObject->readOuterXml() );
                foreach( $location->children() as $type => $details ) {
                    if ($type == "arr") {
                        $et = $this->getDateTime($ssd, $details->attributes()['et']);
                        $update["ta"] = $et;
                        $update["wta"] = $this->getDateTime($ssd, $details->attributes()['wta']);
                    }

                    if ($type == "dep") {
                        $et = $this->getDateTime($ssd, $details->attributes()['et']);
                        $update["td"] = $et;
                        $update["wtd"] = $this->getDateTime($ssd, $details->attributes()['wtd']);
                    }

                    if ($type == "pass") {
                        $et = $this->getDateTime($ssd, $details->attributes()['et']);
                        $update["tp"] = $et;
                        $update["wtp"] = $this->getDateTime($ssd, $details->attributes()['wtp']);
                    }

                    $updates[] = $update;

                    if (count($updates) > 10000) {


                        $this->trainDataStorage->update($updates);

                        $updates = [];
                    }
                }
            }
        }
        
        $this->trainDataStorage->update( $updates );

        $this->trainDataStorage->commit();
    }


    private function getDateTime(&$journeyStartDate, $time){
        $nowDate = $journeyStartDate->copy();
        list($hour, $minute, $second) = explode(':', $time . ":00");
        if (empty($second)){
            $second = 0; // no idea if this'll do anything or not
        }
        $nowDate->setTime($hour, $minute, $second);
        
        if ($journeyStartDate->gte($nowDate)){
            $nowDate->addDay(1);
        }

        return $nowDate->copy();
    }

    
}

// TODO

/*

pear install stomp

Stuck here on:

configure: error: Cannot find OpenSSL's libraries
ERROR: `/tmp/pear/temp/stomp/configure --with-openssl-dir=/usr' failed


<?php

$queue  = '/topic/foo';

try {
    $stomp = new Stomp('tcp://localhost:61613');
    $stomp->subscribe($queue);
    while (true) {
       if ($stomp->hasFrame()) {
           $frame = $stomp->readFrame();
           if ($frame != NULL) {
               print "Received: " . $frame->body . " - time now is " . date("Y-m-d H:i:s"). "\n";
               $stomp->ack($frame);
           }
//       sleep(1);
       }
       else {
           print "No frames to read\n";
       }
    }
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

?>

*/
