<?php

declare(strict_types=1);

namespace Modules\UI\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\UI\Models\FieldOption;

class FieldOptionSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(FieldOption::class);
    }
}
