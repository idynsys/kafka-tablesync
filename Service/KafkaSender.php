<?php

declare(strict_types=1);


namespace Ids\Modules\Synced\Service;

use Ids\Modules\Synced\Model\SyncedModelInterface;
use ThiagoBrauer\LaravelKafka\KafkaProducer;

class KafkaSender
{
    public const DEFAULT_TOPIC_NAME = 'synced';
    private KafkaProducer $producer;
    private KafkaPublisherDataFactory $kafkaPublishDataFactory;

    public function __construct()
    {
        $this->producer = new KafkaProducer();
        $this->kafkaPublishDataFactory = new KafkaPublisherDataFactory();
    }

    /**
     * @throws \JsonException
     */
    public function send(string $event, SyncedModelInterface $model): void
    {
        $data = $this->kafkaPublishDataFactory->create($event, $model);

        $topics = $model->getTopics() ?? [self::DEFAULT_TOPIC_NAME];
        foreach ($topics as $topic) {
            $this->producer->setTopic($topic)->send(json_encode($data->export(), JSON_THROW_ON_ERROR));
        }
    }
}
