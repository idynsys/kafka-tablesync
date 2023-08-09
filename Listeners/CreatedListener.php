<?php

namespace Ids\Modules\Synced\Listeners;

use Ids\Modules\Synced\Events\Created;

class CreatedListener extends AbstractListener
{
    /**
     * @throws \JsonException
     */
    public function handle(Created $event): void
    {
        $this->kafkaSender->send('created', $event->getModel());
    }
}
