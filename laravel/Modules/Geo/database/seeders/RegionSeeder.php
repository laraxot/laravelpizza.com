<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Region::class);
    }
}
