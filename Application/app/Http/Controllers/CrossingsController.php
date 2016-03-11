<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $crossingDownIds = $this->getCrossingsDown();
        
        $🙅🙅 = DB::table('crossings')
            ->where('crossing_type', 'like', 'Public Highway%')
            ->get(['id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lon")]);
        
        $🙅🙅 = array_map(function($🙅) use (&$crossingDownIds) {

            return [
                "id" => (string) $🙅->id,
                "location" => [
                    "lat" => $🙅->lat,
                    "lon" => $🙅->lon
                ],
                "status" => in_array($🙅->id, $crossingDownIds) ? 'down':'up'
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

    function getCrossingsDown() {
        $rows = DB::select("
            select
                distinct crossing_id
            from
                crossing_intersection_time
            where
                from_time < NOW()
            AND
                to_time > NOW()
            AND
                down_time < NOW()
            AND
                up_time > NOW();
        ");

        return array_map(function ($row) {
            return $row->crossing_id;
        }, $rows);
    }

    /**
     * Returns the requested crossing by ID
     * and extended data
     * 
     * @return String
     */
    public function get($🙅🆔)
    {
        $🙅 = DB::table('crossings')->where('id', $🙅🆔)->first([
            'id', 
            DB::raw("x(`loc`) as lat"),  
            DB::raw("y(`loc`) as lon"), 
            DB::raw("cast(no_of_trains as decimal) as no_of_trains"), 
            DB::raw("cast(replace(replace(substring_index(line_speed, '\r', 1), ' (up)',''),' mph','') as decimal) line_speed_up"), 
            DB::raw("cast(replace(if(replace(replace(replace(line_speed, substring_index(line_speed, '\r', 1),''), '\r', ''), ' (down)', '') = '',replace(substring_index(line_speed, '\r', 1), ' (up)',''), replace(replace(replace(line_speed, substring_index(line_speed, '\r', 1),''), '\r', ''), ' (down)', '')),' mph','') as decimal) line_speed_down"),
            'crossing_type',
            'postcode',
            'city',
            'crossing_name'
        ]);
        if ($🙅 != null){
            $🌐 = [ 
                "result" => "OK",
                "data" => [
                    "id" => intval($🙅->id),
                    "location" => [
                        "lat" => $🙅->lat,
                        "lon" => $🙅->lon,
                        "postcode" => $🙅->postcode,
                        "city" => $🙅->city
                    ],
                    "status" => (mt_rand(-1, 0) ? "down" : "up"),
                    "image" => "/crossings/$🙅🆔/image",
                    "line" => [
                        "trainsPerDay" => intval($🙅->no_of_trains),
                        "northSpeed" => intval($🙅->line_speed_up),
                        "southSpeed" => intval($🙅->line_speed_down)
                    ],
                    "type" => $🙅->crossing_type,
                    "name" => $🙅->crossing_name
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
        $rows =  DB::select("
            select
                distinct *
            from
                crossing_intersection_time
            where
                crossing_id = " . $🙅🆔 . "
        ");

        usort($rows, function (&$rowA, &$rowB) {
            return strtotime($rowA->down_time) > strtotime($rowB->down_time) ? 1:-1;
        });

        $rows = array_map(function (&$row) {
            return [
                'trainDepart' => new Carbon($row->from_time)->toIso8601String(),
                'trainArrive' => new Carbon($row->to_time)->toIso8601String(),
                'downTime' => new Carbon($row->down_time)->toIso8601String(),
                'upTime' => new Carbon($row->up_time)->toIso8601String(),
                'duration' => strtotime($row->up_time) - strtotime($row->down_time)
            ];
        }, $rows);


        return [
            'result' => 'OK',
            'data' => $rows

        ];
    }

    public function serveImage($🙅🆔){
        $response = \Response::make(\File::get("/data/crossing_images/".$🙅🆔.".jpg"));
        $response->header('Content-Type', 'image/jpg');
        return $response;
    }
}
