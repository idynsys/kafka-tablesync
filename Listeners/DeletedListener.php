<?php

namespace Ids\Modules\Synced\Listeners;

use Ids\Modules\Synced\Events\Deleted;

class DeletedListener extends AbstractListener
{
    /**
     * @throws \JsonException
     */
    public function handle(Deleted $event): void
    {
        $this->kafkaSender->send('deleted', $event->getModel());
    }
}
