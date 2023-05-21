<?php

namespace Ids\Modules\Synced\Console;

use App\Models\Product;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'test:created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $product = (new Product());
        $product->name = 'test';
        $product->localization_key = 'localization_key_test';
        $product->description = 'description_test';
        $product->save();
    }
}
