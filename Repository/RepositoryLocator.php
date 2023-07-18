<?php

namespace Ids\Modules\Synced\Repository;

use Ids\Modules\Synced\Service\KafkaPublishMetaData;

class RepositoryLocator
{
    private array $repositories = [];

    public function registerSyncedRepository(string $routeKey, SyncedRepositoryInterface $repository): void
    {
        $this->repositories[$routeKey] = $repository;
    }

    public function getRepository($routeKey): SyncedRepositoryInterface
    {
        if ( ! $this->repositories[$routeKey]) {
            throw new \RuntimeException(\sprintf('Unknown route key %s', $routeKey));
        }
        return $this->repositories[$routeKey];
    }
}
