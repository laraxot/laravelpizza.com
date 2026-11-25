<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Pivot rating_morph owner del dominio consumer — seed demandato ai seeder del dominio consumer.
 */
class RatingMorphSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->command !== null) {
            $this->command->info('RatingMorphSeeder: pivot demo demandato ai seeder del dominio consumer.');
        }
    }
}
