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
        echo "\nDownloading Realtime Train Times.";
        
        $file = $this->gateway->getRTTrainData();

        echo "\nDownloaded Realtime Train Times.";

        if( empty($file) ){
            throw new Exception( "No real time train data in file" );
        }

        $this->dealWithFile($file);
    }

    private function dealWithFile($fileContents){
        $xmlLines = explode("\n", $fileContents);

        echo "\nUpdating";
        foreach($xmlLines as $xmlLine){
                $this->dealWithPPMessage($xmlLine);
        }
        echo "\nDone!";
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
        $this->getRidOfNameSpaceCrap( $ppMessageString );
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

        //<TS rid="1" ssd="2016-02-19" uid="C60247">

        while($ppMessageObject->read()){
            if( $ppMessageObject->name == "TS" ){
                $ssd = new Carbon( $ppMessageObject->getAttribute('ssd') );

                $update["rid"] = $ppMessageObject->getAttribute('rid');
                continue;
            }
            if($ppMessageObject->name == 'Location'){

                $update["tpl"] = $ppMessageObject->getAttribute('tpl');

                $location = new \SimpleXMLElement( $ppMessageObject->readOuterXml() );
                foreach( $location->children() as $type => $details ) {
                    /** @var \SimpleXMLElement $details */
                    if ($type == "arr") {
                        $et = $this->getEstimatedOrActualTime( $details );
                        if( !$et ){
                            echo "No estimated or actual time for arrival";
                            continue;
                        }
                        $update["ta"] = $this->getDateTime( $ssd, $et );
                        $update["wta"] = $this->getDateTime($ssd, $location->attributes()['wta']);
                    }

                    if ($type == "dep") {
                        $et = $this->getEstimatedOrActualTime( $details );
                        if( !$et ){
                            echo "No estimated or actual time for departure";
                            continue;
                        }
                        $update["td"] = $this->getDateTime( $ssd, $et );
                        $update["wtd"] = $this->getDateTime($ssd, $location->attributes()['wtd']);
                    }

                    if ($type == "pass") {
                        $et = $this->getEstimatedOrActualTime( $details );
                        if( !$et ){
                            echo "No estimated or actual time for pass through";
                            continue;
                        }
                        $update["tp"] = $this->getDateTime( $ssd, $et );
                        $update["wtp"] = $this->getDateTime($ssd, $location->attributes()['wtp']);
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

    private function getRidOfNameSpaceCrap( &$ppMessageString )
    {
        /*
         * the xmlns stuff inside Pport tags are just attributes which I think are all ok
         *
         * $left = 'xmlns="http://www.thalesgroup.com/rtti/PushPort/v12"';
        $right = 'version="12.0"';
        $le = explode($left, $ppMessageString);
        $ts = explode($right, $le[1])[0];
        $ppMessageString = preg_replace("/<.*(xmlns *= *[\"'].[^\"']*[\"']).[^>]*>/i", "<Pport $ts>", $ppMessageString);*/
        $ppMessageString = preg_replace("/<\/([a-z0-9\-]*)?:/i", "</", $ppMessageString);
        $ppMessageString = preg_replace("/<([a-z0-9\-]*)?:/i", "<", $ppMessageString);

        return $ppMessageString;
    }

    private function getEstimatedOrActualTime( \SimpleXMLElement $details )
    {
        $et = $details->attributes()['et'];
        if ( empty($et) ){
            $et = $details->attributes()['at'];
            if( empty($et) ){
                return false;
            }
        }
        return $et;
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
