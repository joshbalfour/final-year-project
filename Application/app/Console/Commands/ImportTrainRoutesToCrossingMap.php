<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class ImportTrainRoutesToCrossingMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:train-routes-to-crossings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Maps all of the train routes to the crossings in a link table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Linking train routes to crossings\n";
        echo passthru('cd database/train-route-process && node bind-to-crossings.js');
        echo "Completed\n";
    }
}
