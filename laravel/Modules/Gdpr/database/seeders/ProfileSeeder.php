<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gdpr\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Profile::class);
    }
}
