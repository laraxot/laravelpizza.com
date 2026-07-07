<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\Comune;

class ComuneSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Comune::class);
    }
}
