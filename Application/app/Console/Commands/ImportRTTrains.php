<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Gateways\RTTrainDataGateway;
use App\Storage\TrainDataStorage;

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
        
        echo "\nDownloading Realtime Train Times.\n";
        
        $filePaths = $this->gateway->getRTTrainData(1);

        foreach ($filePaths as $filePath){
            $this->dealWithFile($filePath);
        }
    }

    private function dealWithFile($filePath){
        $xmlLines = explode("\n", file_get_contents($filePath));
        
        // debug
        $lineStart = 25;
        $lineLimit = 1;
        $counter = 0;
        $acounter = 0;

        foreach($xmlLines as $xmlLine){
            
            if ($counter < $lineLimit && $acounter > $lineStart){

                $this->dealWithPPMessage($xmlLine);
                
                $counter++;
            }

            $acounter++;
        }
    }

    private function dealWithPPMessage($ppMessageString){
        $ppMessageObject = $this->convertPPMessageStringToObject($ppMessageString);

        // todo
        var_dump($ppMessageObject);
    }

    private function convertPPMessageStringToObject($ppMessageString){
        // don't ask
        $ppMessageString = preg_replace("/<.*(xmlns *= *[\"'].[^\"']*[\"']).[^>]*>/i", "<Pport>", $ppMessageString);
        $ppMessageString = preg_replace("/<\/([a-z0-9\-]*)?:/i", "</", $ppMessageString);
        $ppMessageString = preg_replace("/<([a-z0-9\-]*)?:/i", "<", $ppMessageString);
        
        $xmlData = simplexml_load_string( $ppMessageString, null, LIBXML_NOCDATA);

        // finally a normal object
        return  json_decode(json_encode((array) $xmlData), 1);
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
