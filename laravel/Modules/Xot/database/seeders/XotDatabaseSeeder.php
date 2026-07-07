<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore Xot — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class XotDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (null !== $this->command) {
            $this->command->info('XotDatabaseSeeder: entity seeders…');
        }

        $this->call([
            CacheSeeder::class,
            CacheLockSeeder::class,
            ExtraSeeder::class,
            FeedSeeder::class,
            HealthCheckResultHistoryItemSeeder::class,
            InformationSchemaTableSeeder::class,
            LogSeeder::class,
            ModuleSeeder::class,
            PulseAggregateSeeder::class,
            PulseEntrySeeder::class,
            PulseValueSeeder::class,
            SessionSeeder::class,
        ]);

        if (null !== $this->command) {
            $this->command->info('XotDatabaseSeeder: completato.');
        }
    }
}
