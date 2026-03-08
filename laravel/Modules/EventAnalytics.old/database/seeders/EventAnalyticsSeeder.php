<?php

namespace Modules\EventAnalytics\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EventAnalytics\App\Models\EventAnalytics;

class EventAnalyticsSeeder extends Seeder
{
    public function run(): void
    {
        EventAnalytics::factory()->count(200)->create();
    }
}