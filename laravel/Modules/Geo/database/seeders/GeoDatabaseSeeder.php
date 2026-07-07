<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Orchestratore Geo — N modelli owner = N {Model}Seeder (regola Laraxot).
 */
class GeoDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (null !== $this->command) {
            $this->command->info('GeoDatabaseSeeder: entity seeders…');
        }

        $this->call([
            AddressSeeder::class,
            ComuneSeeder::class,
            ComuneJsonSeeder::class,
            CountySeeder::class,
            GeoNamesCapSeeder::class,
            LocalitySeeder::class,
            LocationSeeder::class,
            PlaceSeeder::class,
            PlaceTypeSeeder::class,
            ProvinceSeeder::class,
            RegionSeeder::class,
            StateSeeder::class,
        ]);

        if (null !== $this->command) {
            $this->command->info('GeoDatabaseSeeder: completato.');
        }
    }
}
