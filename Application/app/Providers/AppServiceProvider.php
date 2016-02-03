<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\Ftp;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( \App\Storage\TrainDataStorage::class, \App\Storage\TrainDataMysqlStorage::class );
        $this->app->bind( \App\Gateways\DailyTrainDataGateway::class, \App\Gateways\DailyTrainDataFtpGateway::class );
        $this->app->bind( \App\Gateways\RTTrainDataGateway::class, \App\Gateways\RTTrainDataFtpGateway::class );
        $this->app->bind( \League\Flysystem\Adapter\AbstractFtpAdapter::class, function(){
            $config = array(
                'host' => 'datafeeds.nationalrail.co.uk',
                'username' => 'ftpuser',
                'password' => 'A!t4398htw4ho4jy'
            );
            return new Ftp( $config );
        } );
    }
}
