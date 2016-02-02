<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class ImportTrainRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:train-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the train routes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Reading data from file\n";
        echo passthru('cd database/train-route-process && node train-routes.js');

        echo "Completed\n";
    }
}
