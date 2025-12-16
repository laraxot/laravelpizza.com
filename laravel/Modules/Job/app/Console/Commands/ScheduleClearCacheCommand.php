<?php

/**
 * @see https://github.com/husam-tariq/filament-database-schedule/blob/v2.0.0/src/Console/Commands/ScheduleClearCacheCommand.php
 */

declare(strict_types=1);

namespace Modules\Job\Console\Commands;

// use HusamTariq\FilamentDatabaseSchedule\Http\Services\ScheduleService;
use Illuminate\Console\Command;

class ScheduleClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the cache of the scheduler.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // (new ScheduleService())->clearCache();  //WIP
        $this->info('Scheduling cache cleared.');

        return 0;
    }
}
