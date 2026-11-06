<?php

declare(strict_types=1);

namespace Modules\UI\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore UI — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class UIDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->command !== null) {
            $this->command->info('UIDatabaseSeeder: entity seeders…');
        }

        $this->call([
            CategorySeeder::class,
            CollectionSeeder::class,
            FieldOptionSeeder::class,
        ]);

        if ($this->command !== null) {
            $this->command->info('UIDatabaseSeeder: completato.');
        }
    }
}
