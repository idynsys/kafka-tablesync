<?php

namespace Ids\Modules\Synced\Model;

interface SyncedModelInterface
{
    public function getRouteKey(): string;
    public function getSyncedAttributes(): array;
}
