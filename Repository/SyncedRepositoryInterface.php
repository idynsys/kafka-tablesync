<?php

namespace Ids\Modules\Synced\Repository;

use Ids\Modules\Synced\Service\KafkaPublishMetaData;

interface SyncedRepositoryInterface
{
    public function create(KafkaPublishMetaData $data);
    public function update(KafkaPublishMetaData $data);
    public function delete(KafkaPublishMetaData $data);
}
