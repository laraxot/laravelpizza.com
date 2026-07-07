<?php

declare(strict_types=1);

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Media\Models\MediaConvert;

class MediaConvertSeeder extends Seeder
{
    public function run(): void
    {
        if (MediaConvert::query()->exists()) {
            return;
        }

        xotSeedModelOnce(MediaConvert::class);
    }
}
