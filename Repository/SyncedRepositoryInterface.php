<?php

namespace Ids\Modules\Synced\Repository;

use Ids\Modules\Synced\Service\KafkaPublishData;

interface SyncedRepositoryInterface
{
    public function createByKafka(KafkaPublishData $data);
    public function updateByKafka(KafkaPublishData $data);
    public function deleteByKafka(KafkaPublishData $data);
}
