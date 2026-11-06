<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\Region;

use function Safe\file_put_contents;
use function Safe\json_encode;
use function Safe\mkdir;

/**
 * RegionSeeder - Popola le 20 regioni italiane con poligoni GeoJSON.
 *
 * Fonte dati: https://github.com/guglielmo/geojson-italy
 * File: geojson/limits_IT_regions.geojson
 *
 * I dati vengono salvati in config/{tenant}/database/content/regions.json
 * tramite il trait SushiToJson (se implementato sul model Region).
 */
class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('RegionSeeder: download dati regioni italiane...');

        $downloader = new GeoJsonDownloader();
        $regions = $downloader->extractRegions();

        if (empty($regions)) {
            $this->command?->error('RegionSeeder: nessun dato regione trovato');

            return;
        }

        $this->command?->info('RegionSeeder: trovate '.count($regions).' regioni');

        // Prepara dati per SushiToJson / JSON export
        $jsonData = [];

        foreach ($regions as $region) {
            $jsonData[] = [
                'id' => $region['id'],
                'istat_code' => $region['istat_code'],
                'iso_code' => $region['iso_code'],
                'name' => $region['name'],
                'geometry' => $region['geometry'],
                'bbox' => $region['bbox'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        // Salva su file JSON per tenant (pattern SushiToJson)
        $this->saveToTenantJson('regions', $jsonData);

        // Esegue il seeding standard via xotSeedModelOnce
        xotSeedModelOnce(Region::class);

        $this->command?->info('RegionSeeder: completato');
    }

    /**
     * Salva i dati nel file JSON del tenant.
     *
     * @param array<int, array<string, mixed>> $data
     */
    protected function saveToTenantJson(string $table, array $data): void
    {
        $tenant = config('tenant.current', 'central');
        $tenant = is_string($tenant) && '' !== $tenant ? $tenant : 'central';
        $path = config_path("{$tenant}/database/content/{$table}.json");

        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0o755, true);
        }

        $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($path, $jsonContent);

        $this->command?->info("RegionSeeder: salvato {$table}.json in {$path}");
    }
}
