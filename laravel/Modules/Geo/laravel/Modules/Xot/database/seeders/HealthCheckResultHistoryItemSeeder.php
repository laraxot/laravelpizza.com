<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Xot\Models\HealthCheckResultHistoryItem;

class HealthCheckResultHistoryItemSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(HealthCheckResultHistoryItem::class);
    }
}
