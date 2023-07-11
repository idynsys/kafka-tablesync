<?php
declare(strict_types=1);

namespace Ids\Modules\Synced\Notifications;

use Ids\Modules\Synced\Events\Created;
use Ids\Modules\Synced\Events\Deleted;
use Ids\Modules\Synced\Events\Updated;
use Illuminate\Notifications\Notifiable;

trait Synced
{
    use Notifiable;

    protected function registerSyncedListeners(): void
    {
        $this->dispatchesEvents = [
            'created' => Created::class,
            'updated' => Updated::class,
            'deleted' => Deleted::class,
        ];
    }
}
