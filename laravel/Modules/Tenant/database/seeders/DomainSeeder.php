<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Models\Domain;

class DomainSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Domain::class);
    }
}
