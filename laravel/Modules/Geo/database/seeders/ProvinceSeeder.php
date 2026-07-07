<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Province::class);
    }
}
