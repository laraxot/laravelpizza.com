<?php

namespace Modules\ForumAnnouncement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ForumAnnouncement\App\Models\ForumAnnouncement;

class ForumAnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        ForumAnnouncement::factory()->count(10)->create();
    }
}