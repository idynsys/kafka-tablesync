<?php

namespace Ids\Modules\Synced\Listeners;

use Ids\Modules\Synced\Events\Created;
use ThiagoBrauer\LaravelKafka\KafkaProducer;

class DeletedListener
{
    private KafkaProducer $producer;

    public function __construct()
    {
        $this->producer = new KafkaProducer();
    }

    public function handle(Created $event): void
    {
        $this->producer->setTopic()->send(json_encode($object->getArray(), JSON_THROW_ON_ERROR));
    }
}
