<?php

namespace Modules\ForumSubscriber\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ForumSubscriber\App\Models\ForumSubscriber;

class ForumSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        ForumSubscriber::factory()->count(100)->create();
    }
}