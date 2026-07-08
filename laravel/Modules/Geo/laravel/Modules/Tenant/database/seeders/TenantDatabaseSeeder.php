<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore Tenant — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class TenantDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if ($this->command !== null) {

            $this->command->info('TenantDatabaseSeeder: entity seeders…');

        }

        $this->call([
            DatabaseConfigSeeder::class,
            DomainSeeder::class,
            TenantSeeder::class,
            TenantDomainSeeder::class,
            TenantSettingSeeder::class,
            TenantSubscriptionSeeder::class,
        ]);

        if ($this->command !== null) {

            $this->command->info('TenantDatabaseSeeder: completato.');

        }
    }
}
