<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gdpr\Models\Consent;

class ConsentSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Consent::class);
    }
}
