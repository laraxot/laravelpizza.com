<?php

declare(strict_types=1);

namespace Modules\UI\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\UI\Models\Collection;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Collection::class);
    }
}
