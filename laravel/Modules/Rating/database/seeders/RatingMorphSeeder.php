<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Pivot rating_morph owner del dominio Predict — seed via Predict\RatingMorphSeeder.
 */
class RatingMorphSeeder extends Seeder
{
    public function run(): void
    {
        if (null !== $this->command) {
            $this->command->info('RatingMorphSeeder: pivot demo in Modules\\Predict\\Database\\Seeders\\RatingMorphSeeder.');
        }
    }
}
