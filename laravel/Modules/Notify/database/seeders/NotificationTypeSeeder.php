<?php

declare(strict_types=1);

namespace Modules\Notify\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notify\Models\NotificationType;

class NotificationTypeSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(NotificationType::class);
    }
}
