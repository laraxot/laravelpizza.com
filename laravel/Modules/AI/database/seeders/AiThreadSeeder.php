<?php

declare(strict_types=1);

namespace Modules\AI\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AI\Database\Factories\AiThreadFactory;
use Modules\AI\Models\AiThread;

class AiThreadSeeder extends Seeder
{
    public function run(): void
    {
        if (AiThread::query()->exists()) {
            return;
        }

        AiThreadFactory::new()->count(2)->create();
    }
}
