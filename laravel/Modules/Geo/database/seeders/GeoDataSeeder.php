<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Geo Data Seeder — comprehensive map data for investor demo.
 * Seeds regions, provinces, comuni, and location data.
 *
 * @see BMAD STORY-371 (Second Brain) · Issue #387 · Discussion #392
 */
class GeoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            ProvinceSeeder::class,
            ComuneSeeder::class,
            ComuneJsonSeeder::class,
            StateSeeder::class,
            CountySeeder::class,
            PlaceTypeSeeder::class,
            PlaceSeeder::class,
            LocationSeeder::class,
            LocalitySeeder::class,
            AddressSeeder::class,
            GeoNamesCapSeeder::class,
        ]);

        // Also export JSON for map reading
        $this->call([GeoJsonExportSeeder::class]);

        $this->command?->info('GeoDataSeeder: complete — DB + JSON ready for demo');
    }
}
