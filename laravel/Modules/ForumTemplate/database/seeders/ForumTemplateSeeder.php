<?php

namespace Modules\ForumTemplate\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ForumTemplate\App\Models\ForumTemplate;

class ForumTemplateSeeder extends Seeder
{
    public function run(): void
    {
        ForumTemplate::factory()->count(10)->create();
    }
}