<?php

declare(strict_types=1);


namespace Ids\Modules\Synced\Service;


class KafkaPublishData
{
    public function __construct(
        private string $event,
        private string $routingKey,
        private array $attributes,
        private KafkaPublishMetaData $metadata,
    ) {
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return KafkaPublishMetaData
     */
    public function getMetadata(): KafkaPublishMetaData
    {
        return $this->metadata;
    }

    public function export(): array
    {
        return [
            'event' => $this->event,
            'routingKey' => $this->routingKey,
            'attributes' => $this->attributes,
            'metadata' => $this->metadata->export(),
        ];
    }
}
