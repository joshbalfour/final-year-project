<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTIPLOCcrsMappings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tiploc-crs-mappings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import TIPLOC to CRS mapping table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Importing TIPLOC to CRS mappings  ...\n";

        echo "\nLoading flat file into memory  ...\n";
        $🔗 = './database/data/CORPUSExtract.json';
        $📁 = file_get_contents($🔗); 
        $🚉🚉 = json_decode($📁, ✅)["TIPLOCDATA"];
        echo "\nLoaded flat file into memory.\n";

        DB::beginTransaction();
        echo "\nImporting into DB...\n";
        $bar = $this->output->createProgressBar(count($🚉🚉));

        $bar->setRedrawFrequency(100);

        $bar->start();

        foreach($🚉🚉 as $🚉){
            DB::table('tiploc_to_crs')->insert($🚉);
            $bar->advance();
        }

        DB::commit();
        $bar->finish();
        echo "\nImported into DB.\n";

        echo "\nImported TIPLOC to CRS mappings.\n";
    }
}
