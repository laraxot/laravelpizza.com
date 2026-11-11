<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore Rating — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class RatingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->command !== null) {
            $this->command->info('RatingDatabaseSeeder: entity seeders…');
        }

        $this->call([
            RatingSeeder::class,
            RatingMorphSeeder::class,
        ]);

        if ($this->command !== null) {
            $this->command->info('RatingDatabaseSeeder: completato.');
        }
    }
}
