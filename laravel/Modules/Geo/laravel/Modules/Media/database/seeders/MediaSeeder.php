<?php

declare(strict_types=1);

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Media\Models\Media;

/**
 * Media demo — schema media (Spatie) + tabelle modulo Media.
 */
class MediaSeeder extends Seeder
{
    public function run(): void
    {
        if (Media::query()->exists()) {
            return;
        }

        xotSeedModelOnce(Media::class);
    }
}
