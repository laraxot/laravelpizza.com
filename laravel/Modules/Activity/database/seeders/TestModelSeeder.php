<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Activity\Models\TestModel;

final class TestModelSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(TestModel::class);
    }
}
