<?php

namespace Ids\Modules\Synced\Providers;

use Ids\Modules\Synced\Console\SyncedConsumerCommand;
use Ids\Modules\Synced\Service\KafkaPublisherDataFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SyncedServiceProvider extends ServiceProvider  implements DeferrableProvider
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
        $this->publishes([
            __DIR__."/../Config/synced.php" => config_path('synced.php'),
        ], 'synced-config');

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
            KafkaPublisherDataFactory::class,
        ];
    }
}
