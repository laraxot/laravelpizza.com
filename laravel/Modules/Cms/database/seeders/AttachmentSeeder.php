<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cms\Models\Attachment;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Attachment::class);
    }
}
