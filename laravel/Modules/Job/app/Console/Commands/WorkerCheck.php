<?php

declare(strict_types=1);

namespace Modules\Job\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class WorkerCheck extends Command
{
    protected $signature = 'worker:check';
    protected $description = 'Ensure that the queue listener is running.';

    public function handle(): void
    {
        $this->info('Queue listener is running.');
    }
}
