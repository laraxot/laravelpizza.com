<?php

declare(strict_types=1);

namespace Modules\Gdpr\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gdpr\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Event::class);
    }
}
