<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Xot\Models\Cache;

class CacheSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Cache::class);
    }
}
