<?php

declare(strict_types=1);

namespace Ids\Modules\Synced\Listeners;

use Ids\Modules\Synced\Service\KafkaSender;

abstract class AbstractListener
{
    protected KafkaSender $kafkaSender;

    public function __construct()
    {
        $this->kafkaSender = app(KafkaSender::class);
    }
}
