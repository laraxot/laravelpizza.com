<?php

declare(strict_types=1);

namespace Modules\AI\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AI\Database\Factories\AiMessageFactory;
use Modules\AI\Models\AiMessage;

class AiMessageSeeder extends Seeder
{
    public function run(): void
    {
        if (AiMessage::query()->exists()) {
            return;
        }

        AiMessageFactory::new()->count(2)->create();
    }
}
