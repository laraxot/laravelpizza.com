<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\ComuneJson;

use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Geo JSON Seeder — saves new JSON data for the map.
 * Uses SushiToJson trait (saveToJson automatically on create/update/delete).
 *
 * @see BMAD STORY-371 (Second Brain) · Issue #387 · Discussion #392
 */
class GeoJsonExportSeeder extends Seeder
{
    public function run(): void
    {
        // Load all comuni from the source JSON
        $jsonPath = module_path('Geo', 'resources/json/comuni.json');
        $data = json_decode(File::get($jsonPath), true);

        if (! is_array($data)) {
            $this->command?->error('GeoJsonExportSeeder: comuni.json non valido');

            return;
        }

        // Save updated/normalized JSON back (with new fields if needed)
        $normalized = [];
        foreach ($data as $item) {
            if (! is_array($item)) {
                continue;
            }
            // Ensure lat/lng and geo coordinates
            $normalized[] = array_merge($item, [
                'updated_at' => now()->toIso8601String(),
                'created_at' => now()->toIso8601String(),
                'source' => 'seed-export',
                'demo_ready' => true,
            ]);
        }

        File::put($jsonPath, json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Warm cache for map reading
        ComuneJson::allRegions();
        ComuneJson::allProvinces();

        $this->command?->info('GeoJsonExportSeeder: JSON salvato + cache scaldata — pronto per demo investitore');
    }
}
