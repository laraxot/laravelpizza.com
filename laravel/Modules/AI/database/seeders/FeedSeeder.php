<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Xot\Models\Feed;

class FeedSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Feed::class);
    }
}
