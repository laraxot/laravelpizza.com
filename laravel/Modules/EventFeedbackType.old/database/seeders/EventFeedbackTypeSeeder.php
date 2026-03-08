<?php

namespace Modules\EventFeedbackType\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\EventFeedbackType\App\Models\EventFeedbackType;

class EventFeedbackTypeSeeder extends Seeder
{
    public function run(): void
    {
        EventFeedbackType::factory()->count(5)->create();
    }
}