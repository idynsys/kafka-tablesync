<?php

declare(strict_types=1);


namespace Ids\Modules\Synced\Service;

class KafkaPublishMetaData
{
    public function __construct(private \DateTime $createdAt)
    {
    }

    public function export(): array
    {
        return [
            'createdAt' => $this->createdAt->format(DATE_ATOM),
        ];
    }
}
