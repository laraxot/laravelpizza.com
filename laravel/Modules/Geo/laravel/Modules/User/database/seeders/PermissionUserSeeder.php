<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\PermissionUser;

class PermissionUserSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(PermissionUser::class);
    }
}
