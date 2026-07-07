<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\ModelHasRole;

class ModelHasRoleSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(ModelHasRole::class);
    }
}
