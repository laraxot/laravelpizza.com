<?php

declare(strict_types=1);

/**
 * @see ---
 */

namespace Modules\DbForge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;

class ViewDatabaseConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:view-db-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' esplode';

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
     */
    public function handle(): void
    {
        Assert::isArray($connections = config('database.connections'));
        $database = Arr::map(
            $connections,
            function (array $item) {
                $item['password'] = '********';

                return $item;
                // return Arr::except($item, ['password']);
            }
        );
        dddx($database);
    }
}
