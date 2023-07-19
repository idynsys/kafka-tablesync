<?php

namespace Ids\Modules\Synced\Providers;

use Ids\Modules\Synced\Console\SyncedConsumerCommand;
use Ids\Modules\Synced\Service\KafkaPublisherDataFactory;
use Illuminate\Support\ServiceProvider;

class SyncedServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Synced';

    protected string $moduleNameLower = 'synced';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    // actually we haven't any commands for now
    //        if ($this->app->runningInConsole()) {
    //            $this->commands([]);
    //        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            EventServiceProvider::class,
            KafkaPublisherDataFactory::class
        ];
    }
}
