<?php

namespace App\Console\Commands;


use \DB;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class ProcessRails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:format-rails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Formats the tails form the import rail map data command.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        echo "Downloading tracks from DB  ...\n";

        $resultLines = DB::table('line')
            ->select('name', DB::raw('AsWKT(line) AS line'))
            ->get();

        $graph = [];
        $this->lines = [];
        $this->points = [];


        echo "Building points cloud  ...\n";
        // Convert the DB rows and file the points and lines array
        foreach ($resultLines as $resultLine) {
            preg_match_all('/([-\d\.]+ [-\d\.]+)/', $resultLine->line, $points);
            $line = $points[0];
            $this->lines[] = $line;

            $pointsInLine = count($line);
            for ($i = 0; $i < $pointsInLine; $i++) {

                $point = [
                    'key' => $line[$i],
                    'lat' => explode(" ", $line[$i])[0],
                    'lng' => explode(" ", $line[$i])[1],
                    'latlng' => explode(" ", $line[$i]),
                    'connectedTo' => [],
                    'line' => &$line
                ];

                if (isset($line[$i - 1])) {
                    $point['connectedTo'][] = $line[$i - 1];
                }
                if (isset($line[$i + 1])) {
                    $point['connectedTo'][] = $line[$i + 1];
                }

                $this->points[$point['key']] = $point;
            }

        }


        foreach ($this->points as &$point) {
            DB::table('test')->insert([
                    "point"   => DB::raw('GeomFromText("point('. implode(" ",$point['latlng']) .')")')
                ]);
        }


        echo "Fully connecting tracks  ...\n";
        $bar = $this->output->createProgressBar(count($this->points), 1);
        $bar->setFormat('very_verbose');


        // Connect the near rows
        foreach ($this->points as &$point) {
            $points = $this->getConnectablePoints($point);
            $points[] = &$point;
            $this->connectPoints($points);
            $bar->advance(1);
        }

        $bar->finish();


        echo "Done\n";
    }

    private function getConnectablePoints(&$point)
    {
        $range = 10; //meters
        $results = [];
        foreach ($this->points as &$checkingPoint) {
            if (
                false &&
                $checkingPoint['line'] != $point['line'] &&
                $this->distanceBetweenPoints($checkingPoint, $point) > $range
                ) {
                $results[] = &$checkingPoint;
            }
        }

        return $results;
    }

    private function distanceBetweenPoints(&$pointA, &$pointB)
    {
        return $this->haversineGreatCircleDistance($pointA['lat'], $pointA['lng'], $pointB['lat'], $pointB['lng']);
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
    }

    private function connectPoints(Array &$points)
    {
        foreach ($points as &$pointA) {
            foreach ($points as &$pointB) {
                if ( !in_array($pointB['key'], $pointA['connectedTo']) ) {
                    $pointA['connectedTo'][] = $pointB['key'];
                }
            }
        }
    }
}
