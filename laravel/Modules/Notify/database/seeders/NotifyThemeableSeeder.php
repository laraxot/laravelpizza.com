<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\NotifyThemeable;

class NotifyThemeableSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(NotifyThemeable::class);
    }
}
