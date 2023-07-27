<?php
namespace Ids\Modules\Synced\Console;

use Ids\Modules\Synced\Kafka\EntityConsumer;
use Illuminate\Console\Command;

class SyncedConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synced consumer start';

    public function __construct()
    {
        $this->signature = config('synced.command-signature', 'consume:entity');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $this->info('consumer is running ...');
        (new EntityConsumer())->consume();
        $this->info('consumer is canceled');

        return Command::SUCCESS;
    }
}
