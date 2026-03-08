<?php

namespace Modules\EventOrganizer\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EventOrganizer\App\Models\EventOrganizer;

class EventOrganizerSeeder extends Seeder
{
    public function run()
    {
        EventOrganizer::factory()->count(10)->create();
    }
}