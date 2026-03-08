<?php

namespace Modules\EventAttendee\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EventAttendee\App\Models\EventAttendee;

class EventAttendeeSeeder extends Seeder
{
    public function run(): void
    {
        EventAttendee::factory()->count(50)->create();
    }
}