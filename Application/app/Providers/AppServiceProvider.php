<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    }
}
