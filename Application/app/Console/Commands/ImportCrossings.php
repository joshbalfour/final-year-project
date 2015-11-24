<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //
        $csvString = file_get_contents('./database/data/Level Crossing Data.csv');
        $csv = str_getcsv($csvString);
        array_shift($csv);
        $toInsert = [];
        foreach ($csv as $row) {
            $toInsert[] = [
                'id' => $row[0]
            ];
        }
        DB::table('crossings')->insert($toInsert);
    }
}
