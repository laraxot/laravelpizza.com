<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\MailTemplateLog;

class MailTemplateLogSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(MailTemplateLog::class);
    }
}
