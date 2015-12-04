<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportExtendedCrossingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:crossings-extended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports extended crossing data.';

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
        
            echo "Importing Level Crossing Images  ...\n";
            $rows = DB::table('crossings')->get(['id']);
            $ids = [];
            
            foreach($rows as $row){
                array_push($ids, $row->id);
            }
        if ($this->confirm('Do you really want to download '.count($rows).' images of level crossings? I won\'t judge you I promise...')) {
            $urls = array_map(function($id){
                return "http://www.networkrail.co.uk/Custom/Images/LevelCrossings/$id/$id.jpg";
            }, $ids);

            $bar = $this->output->createProgressBar(count($urls));
            $bar->setFormat('very_verbose');

            $chunkSize = 100;
            $progress = 0;
            $max = count($urls);

            do {
                $chunk = array_slice($urls, $chunkSize, $progress, false);
                $this->downloadBatch($chunk);
                if ($progress + $chunkSize > $max){
                    $bar->advance($max - $progress);
                    $progress += $max - $progress;
                } else {
                    $bar->advance($chunkSize);
                    $progress += $chunkSize;
                }
            } while ($progress < $max);

            $bar->finish();


            echo "\nImported Level Crossing Images.\n";
        }
    }

    private function downloadBatch($urls){
        // from http://www.jontodd.com/2007/11/08/curl-multi-php-download-how-to/
        $save_path = '/data/crossing_images';

        if (!file_exists($save_path)) {
            mkdir($save_path, 0777, true);
        }

        $multi_handle = curl_multi_init();
        $file_pointers = array();
        $curl_handles = array();  

        // Add curl multi handles, one per file we don't already have  
        foreach ($urls as $key => $url) {
          $file = $save_path.'/'.basename($url);  
          if(!is_file($file)){  
            $curl_handles[$key]=curl_init($url);
            $file_pointers[$key]=fopen ($file, "w");  
            curl_setopt ($curl_handles[$key], CURLOPT_FILE,           $file_pointers[$key]);  
            curl_setopt ($curl_handles[$key], CURLOPT_HEADER ,        0);
            curl_setopt ($curl_handles[$key], CURLOPT_CONNECTTIMEOUT, 60);  
            curl_multi_add_handle ($multi_handle,$curl_handles[$key]);  
          }
        }
          
        // Download the files  
        do {
          curl_multi_exec($multi_handle,$running);
        } while($running > 0);

        // Free up objects  
        foreach ($urls as $key => $url) {
          if (array_key_exists($key, $curl_handles)){
              curl_multi_remove_handle($multi_handle,$curl_handles[$key]);  
              curl_close($curl_handles[$key]);  
          }
          if (array_key_exists($key, $file_pointers)){
            fclose ($file_pointers[$key]);  
          }
        }
        curl_multi_close($multi_handle);
        return;
    }
}
