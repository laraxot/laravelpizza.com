<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Xot\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Module::class);
    }
}
