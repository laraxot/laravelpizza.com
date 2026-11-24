<?php

declare(strict_types=1);

namespace Modules\AI\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AI\Database\Factories\AiActionProposalFactory;
use Modules\AI\Models\AiActionProposal;

class AiActionProposalSeeder extends Seeder
{
    public function run(): void
    {
        if (AiActionProposal::query()->exists()) {
            return;
        }

        AiActionProposalFactory::new()->count(2)->create();
    }
}
