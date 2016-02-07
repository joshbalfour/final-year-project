<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Gateways\RTTrainDataGateway;
use App\Storage\TrainDataStorage;
use Carbon\Carbon;

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
        
        $filePaths = $this->gateway->getRTTrainData(null, $this->output);

        foreach ($filePaths as $filePath){
            $this->dealWithFile($filePath);
        }
    }

    private function dealWithFile($filePath){
        $fc = file_get_contents($filePath);
        $xmlLines = explode("\n", $fc);
        
        // debug
        $lineStart = 47;
        $lineLimit = 1;
        $counter = 0;
        $acounter = 0;

        foreach($xmlLines as $xmlLine){
            
          //  if ($counter < $lineLimit && $acounter > $lineStart){
                $this->dealWithPPMessage($xmlLine, $fc, $filePath);
                
             //   $counter++;
         //   }

           // $acounter++;
        }
    }

    private function dealWithPPMessage($ppMessageString, $xmlLines, $filePath){
        $ppMessageObject = $this->convertPPMessageStringToObject($ppMessageString, $xmlLines, $filePath);
        
        if ($ppMessageObject != null){
            $this->dealWithPPMessageObject($ppMessageObject);
        }
    }

    private function convertPPMessageStringToObject($ppMessageString, $xmlLines, $filePath){

        $orig = $ppMessageString;

        $left = 'xmlns="http://www.thalesgroup.com/rtti/PushPort/v12"';
        $right = 'version="12.0"';
        
        $le = explode($left, $ppMessageString);
        if (count($le) > 1){
            $ts = explode($right, $le[1])[0];

            // don't ask
            $ppMessageString = preg_replace("/<.*(xmlns *= *[\"'].[^\"']*[\"']).[^>]*>/i", "<Pport $ts>", $ppMessageString);
            $ppMessageString = preg_replace("/<\/([a-z0-9\-]*)?:/i", "</", $ppMessageString);
            $ppMessageString = preg_replace("/<([a-z0-9\-]*)?:/i", "<", $ppMessageString);
            
            try {
                $xmlData = simplexml_load_string( $ppMessageString, null, LIBXML_NOCDATA);
            } catch (\Exception $e) {
                 // var_dump($ppMessageString);
                 // var_dump($orig);
                 // var_dump($xmlLines);
                 // var_dump($filePath);
            }

            if (isset($xmlData)){
                // finally a normal object
                return  json_decode(json_encode((array) $xmlData), 1);
            } else {
                echo "\nCorrupt/Incomplete push port message recieved";
                return null;
            }
        } else {
            echo "\nCoudn't get timestamp for push port message";
            return null;
        }
    }

    private function dealWithPPMessageObject($ppMessageObject){

        $updates = [];

        if ( (isset($ppMessageObject["@attributes"]) && isset($ppMessageObject["@attributes"]["ts"])) && (isset($ppMessageObject["uR"]) && isset($ppMessageObject["uR"]["TS"])) ){
            
            $ppMessageTime = new Carbon($ppMessageObject["@attributes"]["ts"]);

            $ts = $ppMessageObject["uR"]["TS"];

            $rid = $ts["@attributes"]["rid"];
            $ssd = new Carbon($ts["@attributes"]["ssd"]);
            // $uid = $ts["@attributes"]["uid"];

            foreach ($ts["Location"] as $location){

                if (isset($location["@attributes"]) && isset($location["@attributes"]["tpl"])){

                    $tiploc = $location["@attributes"]["tpl"];

                    $update = [
                        "ts" => $ppMessageTime,
                        "rid" => $rid,
                        "tpl" => $tiploc,
                        // Illuminate\Support\Facades\DB is dumb and groups queries wrong
                        "ta" => null,
                        "td" => null,
                        "tp" => null,
                        "wta" => null,
                        "wtd" => null,
                        "wtp" => null
                    ];

                    if (isset($location["arr"])){
                        if (isset($location["arr"]["@attributes"]["et"]) && isset($location["@attributes"]["wta"])){
                            $et = $this->getDateTime($ssd, $location["arr"]["@attributes"]["et"]);
                            $update["ta"] = $et;
                            $update["wta"] = $this->getDateTime($ssd, $location["@attributes"]["wta"]);
                        }
                    }

                    if (isset($location["dep"])){
                        if (isset($location["dep"]["@attributes"]["et"]) && isset($location["@attributes"]["wtd"])){
                            $et = $this->getDateTime($ssd, $location["dep"]["@attributes"]["et"]);
                            $update["td"] = $et;
                            $update["wtd"] = $this->getDateTime($ssd, $location["@attributes"]["wtd"]);
                        }
                    }

                    if (isset($location["pass"])){
                        if (isset($location["pass"]["@attributes"]["et"]) && isset($location["@attributes"]["wtp"])){
                            $et = $this->getDateTime($ssd, $location["pass"]["@attributes"]["et"]);
                            $update["tp"] = $et;
                            $update["wtp"] = $this->getDateTime($ssd, $location["@attributes"]["wtp"]);
                        }
                    }

                    $updates[] = $update;

                    if (count($updates) > 10000){

                        $this->trainDataStorage->update( $updates );
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
