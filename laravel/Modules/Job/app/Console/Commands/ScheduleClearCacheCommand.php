<?php

declare(strict_types=1);
/**
 * @see https://github.com/husam-tariq/filament-database-schedule/blob/v2.0.0/src/Console/Commands/ScheduleClearCacheCommand.php
 */

namespace Modules\Job\Console\Commands;

use Illuminate\Console\Command;
use Modules\Job\Actions\ClearScheduleCacheAction;

class ScheduleClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'schedule:clear-cache';

    /**
     * The console command description.
     */
    protected $description = 'Clears the cache of the scheduler.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        app(ClearScheduleCacheAction::class)->execute();
        $this->info('Scheduling cache cleared.');

        return 0;
    }
}
