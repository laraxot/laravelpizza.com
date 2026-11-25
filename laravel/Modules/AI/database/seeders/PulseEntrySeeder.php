<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Xot\Models\PulseEntry;

class PulseEntrySeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(PulseEntry::class);
    }
}
