<?php

declare(strict_types=1);

namespace Modules\AI\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AI\Database\Factories\AiToolLogFactory;
use Modules\AI\Models\AiToolLog;

class AiToolLogSeeder extends Seeder
{
    public function run(): void
    {
        if (AiToolLog::query()->exists()) {
            return;
        }

        AiToolLogFactory::new()->count(2)->create();
    }
}
