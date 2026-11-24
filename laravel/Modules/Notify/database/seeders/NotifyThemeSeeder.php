<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\NotifyTheme;

class NotifyThemeSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(NotifyTheme::class);
    }
}
