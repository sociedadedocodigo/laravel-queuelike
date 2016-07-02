<?php

namespace LaravelQueueLike;

use Illuminate\Support\ServiceProvider;
use LaravelQueueLike\Queue\Connectors\QueueLikeConnector;

class QueueLikeLaravelServiceProvider extends ServiceProvider
{
    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register(){

    }

    public function boot()
    {
        $app = $this->app;
        /**
         * @var \Illuminate\Queue\QueueManager $manager
         */
        $manager = $app['queue'];
        $manager->addConnector('sdcQueueDatabaseLike', function () use ($app) {
            return new QueueLikeConnector($app['db']);
        });
    }

}
