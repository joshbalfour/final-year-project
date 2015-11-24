<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCrossings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:crossings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports crossings.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csvString = file_get_contents('./database/data/Level Crossing Data.csv');
        echo "Importing Level Crossings  ...\n";
        // getCSV does not do what you think it does!!

        $lines = explode(PHP_EOL, $csvString);
        $csv = array();
        foreach ($lines as $line) {
            $csv[] = str_getcsv($line);
        }

        $bar = $this->output->createProgressBar(count($csv));

        array_shift($csv);
        $toInsert = [];
        foreach ($csv as $row) {
            
            $toInsert[] = [
                'id' => $row[0],
                'crossing_name' => $row[1],
                'crossing_type' => $row[2],
                'loc' => DB::raw('GeomFromText("point('.$row[3].' '.$row[4].')")'),
                'postcode' => $row[5],
                'city' => $row[6],
                'types_of_trains' => $row[11],
                'line_speed' => $row[12],
                'no_of_trains' => $row[13]
            ];
            
        }

        DB::table('crossings')->insert($toInsert);
        $bar->finish();

        echo "\nImported Level Crossings.\n";
    }
}
