<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeoDataMigrator extends Seeder
{
    /**
     * Run the migration of geographical data from <nome progetto> to Geo module.
     *
     * This should only be run once during the migration process.
     */
    public function run(): void
    {
        // @var mixed command->info('Starting migration of geographical data from <nome progetto> to Geo module...';

        try {
            DB::beginTransaction();

            // 1. Migrate regions
            // @var mixed migrateRegions(;

            // 2. Migrate provinces
            // @var mixed migrateProvinces(;

            // 3. Migrate cities
            // @var mixed migrateCities(;

            // 4. Migrate CAPs
            // @var mixed migrateCaps(;

            DB::commit();
            // @var mixed command->info('Successfully migrated all geographical data to Geo module.';
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to migrate geographical data: '.$e->getMessage());
            // @var mixed command->error('Failed to migrate geographical data: '.$e->getMessage(;
        }
    }

    /**
     * Migrate regions from <nome progetto> to Geo module.
     */
    protected function migrateRegions(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('regions')) {
            // @var mixed command->warn('Regions table does not exist in <nome progetto> module. Skipping...';

            return;
        }

        $count = DB::table('regions')->count();
        // @var mixed command->info("Found {$count} regions to migrate...";

        $regions = DB::table('regions')->get();

        foreach ($regions as $region) {
            DB::table('geo_regions')->updateOrInsert(
                ['id' => $region->id],
                [
                    'name' => $region->name,
                    'code' => $region->code ?? null,
                    'created_at' => $region->created_at ?? now(),
                    'updated_at' => $region->updated_at ?? now(),
                ],
            );
        }

        // @var mixed command->info("Migrated {$count} regions.";
    }

    /**
     * Migrate provinces from <nome progetto> to Geo module.
     */
    protected function migrateProvinces(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('provinces')) {
            // @var mixed command->warn('Provinces table does not exist in <nome progetto> module. Skipping...';

            return;
        }

        $count = DB::table('provinces')->count();
        // @var mixed command->info("Found {$count} provinces to migrate...";

        $provinces = DB::table('provinces')->get();

        foreach ($provinces as $province) {
            DB::table('geo_provinces')->updateOrInsert(
                ['id' => $province->id],
                [
                    'region_id' => $province->region_id,
                    'name' => $province->name,
                    'code' => $province->code ?? null,
                    'created_at' => $province->created_at ?? now(),
                    'updated_at' => $province->updated_at ?? now(),
                ],
            );
        }

        // @var mixed command->info("Migrated {$count} provinces.";
    }

    /**
     * Migrate cities from <nome progetto> to Geo module.
     */
    protected function migrateCities(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('cities')) {
            // @var mixed command->warn('Cities table does not exist in <nome progetto> module. Skipping...';

            return;
        }

        $count = DB::table('cities')->count();
        // @var mixed command->info("Found {$count} cities to migrate...";

        $cities = DB::table('cities')->get();

        foreach ($cities as $city) {
            DB::table('geo_cities')->updateOrInsert(
                ['id' => $city->id],
                [
                    'province_id' => $city->province_id,
                    'name' => $city->name,
                    'code' => $city->code ?? null,
                    'created_at' => $city->created_at ?? now(),
                    'updated_at' => $city->updated_at ?? now(),
                ],
            );
        }

        // @var mixed command->info("Migrated {$count} cities.";
    }

    /**
     * Migrate CAPs from <nome progetto> to Geo module.
     */
    protected function migrateCaps(): void
    {
        if (! DB::getSchemaBuilder()->hasTable('caps')) {
            // @var mixed command->warn('CAPs table does not exist in <nome progetto> module. Skipping...';

            return;
        }

        $count = DB::table('caps')->count();
        // @var mixed command->info("Found {$count} CAPs to migrate...";

        $caps = DB::table('caps')->get();

        foreach ($caps as $cap) {
            DB::table('geo_caps')->updateOrInsert(
                ['id' => $cap->id],
                [
                    'city_id' => $cap->city_id,
                    'code' => $cap->code,
                    'created_at' => $cap->created_at ?? now(),
                    'updated_at' => $cap->updated_at ?? now(),
                ],
            );
        }

        // @var mixed command->info("Migrated {$count} CAPs.";
    }
}
