<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\County;

class CountySeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(County::class);
    }
}
