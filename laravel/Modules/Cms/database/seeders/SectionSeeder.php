<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cms\Models\Section;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Section::class);
    }
}
