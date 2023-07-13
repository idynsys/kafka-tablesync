<?php
namespace Ids\Modules\Synced\Events;

use Ids\Modules\Synced\Model\SyncedModelInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Updated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private SyncedModelInterface $model)
    {
    }

    /**
     * @return SyncedModelInterface
     */
    public function getModel(): SyncedModelInterface
    {
        return $this->model;
    }
}
