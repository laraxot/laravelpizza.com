<?php

declare(strict_types=1);

namespace Modules\Activity\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore Activity — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class ActivityDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->command !== null) {

            $this->command->info('ActivityDatabaseSeeder: entity seeders…');

        }

        $this->call([
            ActivitySeeder::class,
            SnapshotSeeder::class,
            StoredEventSeeder::class,
        ]);

        if ($this->command !== null) {

            $this->command->info('ActivityDatabaseSeeder: completato.');

        }
    }
}
