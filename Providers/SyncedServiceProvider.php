<?php

namespace Ids\Modules\Synced\Providers;

use Ids\Modules\Synced\Console\SyncedConsumerCommand;
use Ids\Modules\Synced\Events\Created;
use Ids\Modules\Synced\Events\Deleted;
use Ids\Modules\Synced\Events\Updated;
use Ids\Modules\Synced\Listeners\CreatedListener;
use Ids\Modules\Synced\Listeners\DeletedListener;
use Ids\Modules\Synced\Listeners\UpdatedListener;
use Ids\Modules\Synced\Service\KafkaPublisherDataFactory;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class SyncedServiceProvider extends EventServiceProvider implements DeferrableProvider
{

    protected $listen = [
        Created::class => [CreatedListener::class],
        Updated::class => [UpdatedListener::class],
        Deleted::class => [DeletedListener::class],
    ];
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
            KafkaPublisherDataFactory::class,
        ];
    }
}
