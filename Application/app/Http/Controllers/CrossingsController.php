<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CrossingsController extends Controller
{

    /**
     * Returns all of the current crossing with
     * a small piece of data and their current up/down status
     * 
     * @return String
     */
    public function index()
    {
        $🙅🙅 = DB::table('crossings')->get(['id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lon")]);
        
        $🙅🙅 = array_map(function($🙅){

            return [
                "id" => (string) $🙅->id,
                "location" => [
                    "lat" => $🙅->lat,
                    "lon" => $🙅->lon
                ],
                "status" => (mt_rand(-1, 0) ? "down" : "up")
            ];

        }, $🙅🙅);

        if (count($🙅🙅) == 0){
            $🌐 = [
                "result" => "ERROR",
                "error" => "crossings.not_found",
                "error_message" => "No Crossings Found"
            ];
        } else {
            $🌐 = [
                "result" => "OK",
                "data" => $🙅🙅
            ];
        }
        return json_encode($🌐);
    }

    /**
     * Returns the requested crossing by ID
     * and extended data
     * 
     * @return String
     */
    public function get($🙅🆔)
    {
        $🙅 = DB::table('crossings')->where('id', $🙅🆔)->first(['id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lon")]);
        if ($🙅 != null){
            $🌐 = [ 
                "result" => "OK",
                "data" => [
                    "id" => $🙅->id,
                    "location" => [
                        "lat" => $🙅->lat,
                        "lon" => $🙅->lon
                    ],
                    "status" => (mt_rand(-1, 0) ? "down" : "up"),
                    "image" => "/crossings/$🙅🆔/image",
                    "line" => [
                        "trainsPerDay" => 100,
                        "northSpeed" => 100,
                        "southSpeed" => 100
                    ]
                ]
            ];
        } else {
            $🌐 = [
                "result" => "ERROR",
                "error" => "crossing.not_found",
                "error_message" => "Crossing with id ".$🙅🆔." does not exist"
            ];
        }
        

        return json_encode($🌐);
    }

    public function getTimes($🙅🆔){
        return json_encode([]);
    }

    public function serveImage($🙅🆔){
        $response = \Response::make(\File::get("/data/crossing_images/".$🙅🆔.".jpg"));
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }
}
