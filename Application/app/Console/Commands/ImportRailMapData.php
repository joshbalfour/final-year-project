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
    
    private $beyondAllHope = [
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
        ""
    ];

    private $fixes = [
        ["loc" => "52.133082410685 -3.5305592623795", "newloc" => "52.133082410685 -3.5305592623795", "newcrs" => "GTH" ],
        ["loc" => "50.911540234104 -1.4340410281041", "newloc" => "50.911540234104 -1.4340410281041", "newcrs" => "MBK"],
        ["loc" => "54.929821067072 -1.3866108693775", "newloc" => "54.929821067072 -1.3866108693775", "newcrs" => "SEB"]
    ];

    /*
    IDK:
        XXX, POINT(51.516275814066 0.0059468306892281) -> Canning Town DLR station
        
    */


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $🚉 = $this->get🚉();
        DB::beginTransaction();
        foreach($🚉 as $🛤){
            DB::table('station')->insert($🛤);
        }
        DB::commit();
    }

    private function get🚉(){
        $🔗 = "http://inspire.misoportal.com/geoserver/transport_direct_railnetwork/wfs?amp;version=2.0.0&SERVICE=WFS&VERSION=1.0.0&REQUEST=GetFeature&TYPENAME=transport_direct_railnetwork:stations&SRSNAME=EPSG:4326&outputFormat=json";
        $📁 = file_get_contents($🔗);
        $🚉 = json_decode($📁, ✅)["features"];

        $🆕🚉 = array_filter(array_map(function($🛤){
            $🆕🛤 = [];
            $🆕🛤["loc"] = DB::raw("GeomFromText('point(".$🛤["geometry"]["coordinates"][1]." ".$🛤["geometry"]["coordinates"][0].")')");
            $🆕🛤["crs"] = $🛤["properties"]["stn_code"];
            if ($🆕🛤["crs"]){
                return $🆕🛤;
            }
        }, $🚉));

        return $🆕🚉;
    }
}
