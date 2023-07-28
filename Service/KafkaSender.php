<?php

declare(strict_types=1);


namespace Ids\Modules\Synced\Service;

use Ids\Modules\Synced\Model\SyncedModelInterface;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Illuminate\Support\Facades\Log;

class KafkaSender
{
    private KafkaPublisherDataFactory $kafkaPublishDataFactory;

    public function __construct()
    {
        $this->kafkaPublishDataFactory = new KafkaPublisherDataFactory();
    }

    public function send(string $event, SyncedModelInterface $model): void
    {
        $data = $this->kafkaPublishDataFactory->create($event, $model);
        $topics = $model->getTopics();
        if (!in_array($model->getRouteKey(), $topics)) {
            $topics[] = $model->getRouteKey();
        }
        foreach ($topics as $topic) {
            $message = Message::create($topic, RD_KAFKA_PARTITION_UA)->withBody(['body' => $data->export()]);
            Kafka::publishOn($topic)->withMessage($message)->send();
        }
    }
}
