<?php

declare(strict_types=1);

namespace Ids\Modules\Synced\Providers;

use Ids\Modules\Synced\Events\Created;
use Ids\Modules\Synced\Events\Deleted;
use Ids\Modules\Synced\Events\Updated;
use Ids\Modules\Synced\Listeners\CreatedListener;
use Ids\Modules\Synced\Listeners\DeletedListener;
use Ids\Modules\Synced\Listeners\UpdatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Created::class => [CreatedListener::class],
        Updated::class => [UpdatedListener::class],
        Deleted::class => [DeletedListener::class],
    ];
}
