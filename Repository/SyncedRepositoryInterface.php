<?php

namespace Ids\Modules\Synced\Repository;

use Ids\Modules\Synced\Service\KafkaPublishData;

interface SyncedRepositoryInterface
{
    public function create(KafkaPublishData $data);
    public function update(KafkaPublishData $data);
    public function delete(KafkaPublishData $data);
}
