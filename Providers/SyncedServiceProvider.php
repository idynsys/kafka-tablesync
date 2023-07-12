<?php

namespace Ids\Modules\Synced\Providers;

use Ids\Modules\Synced\Console\SyncedConsumerCommand;
use Ids\Modules\Synced\Service\KafkaPublisherDataFactory;
use Illuminate\Support\ServiceProvider;

class SyncedServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Synced';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'synced';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([SyncedConsumerCommand::class]);
        }
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
