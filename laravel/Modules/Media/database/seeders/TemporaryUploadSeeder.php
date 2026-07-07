<?php

declare(strict_types=1);

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Media\Models\TemporaryUpload;

class TemporaryUploadSeeder extends Seeder
{
    public function run(): void
    {
        if (TemporaryUpload::query()->exists()) {
            return;
        }

        xotSeedModelOnce(TemporaryUpload::class);
    }
}
