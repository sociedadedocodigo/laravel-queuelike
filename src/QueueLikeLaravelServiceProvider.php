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
    public function register()
    {
        /**
         * @var \Illuminate\Queue\QueueManager $manager
         */
        $manager = $this->app['queue'];
        $manager->addConnector('sdcQueueDatabaseLike', function () use ($app) {
            return new QueueLikeConnector($this->app['db']);
        });
    }

}
