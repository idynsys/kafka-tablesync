<?php

namespace Ids\Modules\Synced\Listeners;

use Ids\Modules\Synced\Events\Updated;

class UpdatedListener extends AbstractListener
{
    /**
     * @throws \JsonException
     */
    public function handle(Updated $event): void
    {
        $this->kafkaSender->send('updated', $event->getModel());
    }
}
