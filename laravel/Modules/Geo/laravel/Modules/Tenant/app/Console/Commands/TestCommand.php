<?php

declare(strict_types=1);

namespace Modules\Tenant\Console\Commands;

use Illuminate\Console\Command;
use Modules\Tenant\Services\TenantService;

class TestCommand extends Command
{
    protected $signature = 'tenant:test';

    protected $description = 'Check Tenant';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = TenantService::getName();
        $this->info('tenant name :'.$name);
    }
}
