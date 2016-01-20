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
        $contents = \File::get('database/data/train_routes.sql');
        echo "Spliting string\n";

        $splitSection = "INSERT INTO `train_routes`";
        $insertables = explode($splitSection, $contents);
        $bar = $this->output->createProgressBar(count($insertables));

        echo "Inserting\n";
        foreach($insertables as $statement) {
            if (trim($statement) !== '') {
                \DB::statement($splitSection . $statement);
            } 
            \DB::commit();
            $bar->advance();
        }

        echo "Completed\n";
    }
}
