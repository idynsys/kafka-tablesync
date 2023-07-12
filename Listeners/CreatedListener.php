<?php

namespace Ids\Modules\Synced\Listeners;

use Ids\Modules\Synced\Events\Created;
use Ids\Modules\Synced\Service\KafkaSender;

class CreatedListener
{
    public function handle(Created $event): void
    {
        $kafka = app(KafkaSender::class);
        $kafka->send('create', $event->getModel());
        //$this->producer->setTopic()->send(json_encode($object->getArray(), JSON_THROW_ON_ERROR));
    }
}
