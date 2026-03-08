<?php

namespace Modules\EventNotification\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EventNotification\App\Models\EventNotification;

class EventNotificationSeeder extends Seeder
{
    public function run(): void
    {
        EventNotification::factory()->count(100)->create();
    }
}