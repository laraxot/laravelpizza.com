<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\State;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(State::class);
    }
}
