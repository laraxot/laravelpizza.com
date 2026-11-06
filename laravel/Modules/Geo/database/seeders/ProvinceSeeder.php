<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\Province;

use function Safe\file_put_contents;
use function Safe\json_encode;
use function Safe\mkdir;

/**
 * ProvinceSeeder - Popola le 107+ province italiane con confini GeoJSON.
 *
 * Fonte dati: https://github.com/guglielmo/geojson-italy
 * File: geojson/limits_IT_provinces.geojson
 *
 * Include: province, città metropolitane, province autonome
 * I dati vengono salvati in config/{tenant}/database/content/provinces.json
 */
class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('ProvinceSeeder: download dati province italiane...');

        $downloader = new GeoJsonDownloader();
        $provinces = $downloader->extractProvinces();

        if (empty($provinces)) {
            $this->command?->error('ProvinceSeeder: nessun dato provincia trovato');

            return;
        }

        $this->command?->info('ProvinceSeeder: trovate '.count($provinces).' province');

        // Prepara dati per SushiToJson / JSON export
        $jsonData = [];

        foreach ($provinces as $province) {
            $jsonData[] = [
                'id' => $province['id'],
                'istat_code' => $province['istat_code'],
                'uts_code' => $province['uts_code'],
                'iso_code' => $province['iso_code'],
                'acronym' => $province['acronym'],
                'name' => $province['name'],
                'type' => $province['type'],
                'region_id' => $province['region_id'],
                'region_istat_code' => $province['region_istat_code'],
                'region_name' => $province['region_name'],
                'geometry' => $province['geometry'],
                'bbox' => $province['bbox'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        // Salva su file JSON per tenant
        $this->saveToTenantJson('provinces', $jsonData);

        // Esegue il seeding standard via xotSeedModelOnce
        xotSeedModelOnce(Province::class);

        $this->command?->info('ProvinceSeeder: completato');
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

        $this->command?->info("ProvinceSeeder: salvato {$table}.json in {$path}");
    }
}
