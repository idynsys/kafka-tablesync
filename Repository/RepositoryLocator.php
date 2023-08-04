<?php

namespace Ids\Modules\Synced\Repository;

use Ids\Modules\Synced\Service\KafkaPublishData;
use Ids\Modules\Synced\Exception\UnknownStateException;

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

    public function getRoutes(): array
    {
        return array_keys($this->repositories);
    }

    public function process(KafkaPublishData $data): void
    {
        $repo = $this->getRepository($data->getRoutingKey());
        switch ($data->getEvent()) {
            case 'create':
                $repo->createByKafka($data);
                break;
            case 'update':
                $repo->updateByKafka($data);
                break;
            case 'delete':
                $repo->deleteByKafka($data);
                break;
            default:
                throw new UnknownStateException($data->getEvent());
        }
    }
}
