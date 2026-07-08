<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\SocialiteUser;

class SocialiteUserSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(SocialiteUser::class);
    }
}
