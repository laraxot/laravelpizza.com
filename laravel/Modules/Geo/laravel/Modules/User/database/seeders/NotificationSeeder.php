<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        xotSeedModelOnce(Notification::class);
    }
}
