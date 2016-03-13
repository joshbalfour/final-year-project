<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DebugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$line = DB::table('line')->get(['name', DB::raw("ST_AsText(`line`) as loc")]);
        $crossings = DB::table('crossings')->get(['id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lng")]);
        $station = DB::table('station')->get(['crs as id', DB::raw("x(`loc`) as lat"),  DB::raw("y(`loc`) as lng")]);

        return json_encode([$station, $crossings]);
    }

    public function distanceBetweenPoints(&$pointA, &$pointB) {
        $lat1 = $pointA[0];
        $lon1 = $pointA[1];
        $lat2 = $pointB[0];
        $lon2 = $pointB[1];
        $rad = M_PI / 180;
        return sqrt( pow($lat1 - $lat2, 2) +  pow($lon1 - $lon2, 2));
    }

    public function trainLocations()
    {
        $trainPositionLocations = DB::select("
            select
                train_times_with_crs.rid,
                train_times_with_crs.from_time,
                train_times_with_crs.to_time,
                CONCAT(ST_AsGeoJSON(train_routes.route), ' ') as route,
                GLength(train_routes.route) as route_distance
            from
                train_times_with_crs
            join
                train_routes
                on
                    train_times_with_crs.to_crs = train_routes.to
                and
                    train_times_with_crs.from_crs = train_routes.from
            where
                to_time > NOW()
            and
                from_time < NOW()
            and
                from_crs != to_crs

        ");

        $trains = array_map(function ($row) {
            try {
                $currentTime = time();
                $departTime = strtotime($row->from_time);
                $arrivalTime = strtotime($row->to_time);

                $percetangeLongTrack = ($currentTime - $departTime) / ($arrivalTime - $departTime);

                $distanceLongTrack = $row->route_distance * $percetangeLongTrack;
                $distanceTracker = 0;
                $oldDistance = 0;
                $trackPoints = json_decode($row->route);
                $trackPoints = $trackPoints->coordinates;

                $trackPointsCount = count($trackPoints);
                $steps = [];


                for($i = 1; $i < $trackPointsCount; $i++) {
                    $prevPoint = $trackPoints[$i - 1];
                    $curPoint = $trackPoints[$i];

                    $steps[] = [
                        $this->distanceBetweenPoints($prevPoint, $curPoint)
                        ,$prevPoint,$curPoint, $distanceTracker
                    ];
                    $distanceTracker += $this->distanceBetweenPoints($prevPoint, $curPoint);

                    if ($distanceTracker > $distanceLongTrack) {
                        break;
                    }
                    $oldDistance = $distanceTracker;

                }
                $distanceBetweenPoints = ($distanceLongTrack - $oldDistance) / ($distanceTracker - $oldDistance);

                return [
                    'location' => [
                        'x' => $prevPoint[0] + (($curPoint[0] - $prevPoint[0]) * $distanceBetweenPoints) ,
                        'y' => $prevPoint[1] + (($curPoint[1] - $prevPoint[1]) * $distanceBetweenPoints) ,
                    ],
                    'rid' => $row->rid
                ];
            } catch (\Exception $e) {
                return null;
            }

        }, $trainPositionLocations);
    
        $trains = array_filter($trains);

        return [
            "status" => "OK",
            "data" => $trains //array_slice($trains, 3, 1)
        ];
    }

}
