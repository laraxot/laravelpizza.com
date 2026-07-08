<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Tenant::class);
    }
}
