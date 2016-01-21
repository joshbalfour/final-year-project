<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class ImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports everything';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "\n\n--- Inspire me\n";
        $this->call('inspire');

        echo "\n\n--- Reseting database\n";
        $this->call('migrate:refresh');

        echo "\n\n--- Importing crossings\n";
        $this->call('import:crossings');
        
        echo "\n\n--- Importing extended crossings\n";
        $this->call('import:crossings-extended', ['--force' => true]);

        echo "\n\n--- Importing daily train data\n";
        $this->call('import:daily-train-data');

        echo "\n\n--- Importing tiploc map\n";
        $this->call('import:tiploc-crs-mappings');

        echo "\n\n--- Importing train routes\n";
        $this->call('import:train-routes');

        echo "\n\n--- Importing train routes to crossings map\n";
        $this->call('import:train-routes-to-crossings');

    }
}
