<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Models\TenantSetting;

class TenantSettingSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(TenantSetting::class);
    }
}
