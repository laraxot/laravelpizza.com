<?php

namespace Modules\ForumPermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ForumPermission\App\Models\ForumPermission;

class ForumPermissionSeeder extends Seeder
{
    public function run(): void
    {
        ForumPermission::factory()->count(20)->create();
    }
}