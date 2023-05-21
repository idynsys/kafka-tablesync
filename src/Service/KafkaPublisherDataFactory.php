<?php

declare(strict_types=1);


namespace Ids\Modules\Synced\Service;

use Ids\Modules\Synced\Model\SyncedModelInterface;

class KafkaPublisherDataFactory
{
    public function create(string $event, SyncedModelInterface $model): KafkaPublishData
    {
        return new KafkaPublishData(
            $event,
            $model->getRouteKey(),
            $model->getSyncedAttributes(),
            new KafkaPublishMetaData(new \DateTime())
        );
    }

    /**
     * @throws \JsonException
     */
    public function createByJson(string $json): KafkaPublishData
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        dump($data);

        return new KafkaPublishData(
            $data['event'],
            $data['routingKey'],
            $data['attributes'],
            new KafkaPublishMetaData(\DateTime::createFromFormat(\DateTime::ATOM, $data['metadata']['createdAt'])),
        );
    }
}
