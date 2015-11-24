<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

const ✅ = true;
const ❌ = false;

class ImportRailMapData extends Command
{
    /**
     * 
     *
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:rail-map-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads and imports both railways and stations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    private $😭 = [
        "55.858491196471 -4.2579214593015",
        "55.86246939742 -4.2512323293334",
        "51.546032544248 -0.10437537844082",
        "53.357161797481 -2.8946599588279",
        "52.923935079809 -4.1266195041572",
        "53.214433172239 -3.0377214146243",
        "51.531574342925 -0.24371821710422",
        "50.88899483197 -1.4555491636966",
        "51.458992697288 -0.21061640334931",
        "52.904036857911 -1.4662150516188",
        "51.432977074863 -0.19527830199057",
        "53.791386865966 -1.5588181585099",
        "51.499387594066 0.06244811362876",
        "51.501976428555 0.04608124626708",
        "51.446339292655 -0.20664094881693",
        "50.88899483197 -1.4555491636966",
        "51.651026673924 -0.42897654482917",
        "51.509731522817 0.026728532247945",
        "51.646316660556 -0.40708288663889",
        "51.648368083754 -0.41381899627169",
        "51.434510411551 -0.19941166373611",
        "51.516275814066 0.0059468306892281"
    ];

    private $🚑 = [
        ["loc" => "52.133082410685 -3.5305592623795", "newloc" => "52.133082410685 -3.5305592623795", "newcrs" => "GTH" ],
        ["loc" => "50.911540234104 -1.4340410281041", "newloc" => "50.911540234104 -1.4340410281041", "newcrs" => "MBK"],
        ["loc" => "54.929821067072 -1.3866108693775", "newloc" => "54.929821067072 -1.3866108693775", "newcrs" => "SEB"],
        ["loc" => "50.732296685048 -3.9968064717481", "newloc" => "50.732296685048 -3.9968064717481", "newcrs" => "OKE"]
    ];

    private function applyFixes(){

        foreach($this->🚑 as $🤕){
            
            DB::table('station')
                ->where('loc', DB::raw('GeomFromText("point('.$🤕["loc"].')")'))
                ->update([
                    'loc' => DB::raw('GeomFromText("point('.$🤕["newloc"].')")'), 
                    'crs' => $🤕["newcrs"] ]);
        }

        foreach($this->😭 as $😢){
             DB::table('station')
                ->where('loc', DB::raw('GeomFromText("point('.$😢.')")'))
                ->delete();
        }
    }
    
    //$mainbar = $this->output->createProgressBar(100);

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $bar = $this->output->createProgressBar(100);
        $this->import🛤🛤();
        $this->import🚉🚉();
    }

    private function import🚉🚉(){
        echo "Importing 🚉  ...\n";

        echo "Downloading 🚉  ...\n";
        $🚉🚉 = $this->get🚉🚉();
        echo "Downloaded  🚉   ✅ \n";
        
        echo "Loading 🚉  to Database...\n";
        $🚉bar = $this->output->createProgressBar(count($🚉🚉));
        
        $🚉bar->start();

        DB::beginTransaction();
        
        foreach($🚉🚉 as $🚉){
            DB::table('station')->insert($🚉);
            $🚉bar->advance();
        }
        echo "\nLoaded 🚉  to Database   ✅ \n";

        echo "Fixing 🚉  in Database...\n";
        $this->applyFixes();
        echo "Fixed 🚉  in Database   ✅\n";

        DB::commit();
        $🚉bar->finish();
        echo "\nImported 🚉   ✅  ✅\n";
    }

    private function get🚉🚉(){
        $🔗 = "http://inspire.misoportal.com/geoserver/transport_direct_railnetwork/wfs?amp;version=2.0.0&SERVICE=WFS&VERSION=1.0.0&REQUEST=GetFeature&TYPENAME=transport_direct_railnetwork:stations&SRSNAME=EPSG:4326&outputFormat=json";
        $📁 = file_get_contents($🔗);
        $🚉🚉 = json_decode($📁, ✅)["features"];

        $🆕🚉🚉 = array_filter(array_map(function($🚉){
            $🆕🚉 = [];
            $🆕🚉["loc"] = DB::raw("GeomFromText('point(".$🚉["geometry"]["coordinates"][1]." ".$🚉["geometry"]["coordinates"][0].")')");
            $🆕🚉["crs"] = $🚉["properties"]["stn_code"];
            if ($🆕🚉["crs"]){
                return $🆕🚉;
            }
        }, $🚉🚉));

        return $🆕🚉🚉;
    }

    private function import🛤🛤(){
        echo "Importing 🛤  ...\n";

        echo "Downloading 🛤  ...\n";
        $🛤🛤 = $this->get🛤🛤();
        echo "Downloaded  🛤   ✅ \n";

        echo "Loading 🛤 to Database...\n";
        $🛤bar = $this->output->createProgressBar(count($🛤🛤));
        $🛤bar->start();

        DB::beginTransaction();

        foreach($🛤🛤 as $🛤){
            DB::table('line')->insert([
                    "name"   => $🛤["📛"],
                    "line"   => DB::raw('GeomFromText("linestring('.$🛤["🛤"].')")'),
                    "status" => $🛤["🚦"],
                ]);
            $🛤bar->advance();
        }

        DB::commit();
        $🛤bar->finish();
        echo "\nLoaded 🛤 to Database ✅ \n";

        echo "Imported 🛤  ✅  ✅ \n";
    }

    private function 📍📍🔀🛤($📍📍){
        $🆕📍📍 = array_map(function($📍){
            return $📍[1]." ".$📍[0];
        }, $📍📍);

        return implode( ",", $🆕📍📍);
    }

    private function get🛤🛤(){

         $🔗 = "http://inspire.misoportal.com/geoserver/transport_direct_railnetwork/wfs?amp;version=2.0.0&SERVICE=WFS&VERSION=1.0.0&REQUEST=GetFeature&TYPENAME=transport_direct_railnetwork:railnetwork&SRSNAME=EPSG:4326&outputFormat=json";
         $📁 = file_get_contents($🔗);
         $🗺🗺 = json_decode($📁, ✅)["features"];

         $🛤🛤 =[];

         // $🔢 = 0;

         foreach($🗺🗺 as $🗺){

            if ($🗺["geometry"]["type"] == 'LineString'){

                $🛤 = [ 
                    "📛" => $🗺["properties"]["businessre"], 
                    "🚦" => $🗺["properties"]["status"], 
                    "🛤" => $this->📍📍🔀🛤($🗺["geometry"]["coordinates"])
                ];

                array_push($🛤🛤, $🛤);

            } else if ($🗺["geometry"]["type"] == 'MultiLineString') {

                $🚦 = $🗺["properties"]["status"];
                $📛 = $🗺["properties"]["businessre"];

                foreach($🗺["geometry"]["coordinates"] as $🗺){
                    
                    $🛤 = [ 
                        "📛" => $📛, 
                        "🚦" => $🚦,
                        "🛤" => $this->📍📍🔀🛤($🗺)
                    ];
                    
                    array_push($🛤🛤, $🛤);

                }

            }

         }


         return $🛤🛤;
    }

}
