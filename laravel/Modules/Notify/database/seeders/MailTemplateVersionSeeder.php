<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\MailTemplateVersion;

class MailTemplateVersionSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(MailTemplateVersion::class);
    }
}
