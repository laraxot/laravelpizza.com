<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Geo\Models\Comune;

use function Safe\file_put_contents;
use function Safe\json_encode;
use function Safe\mkdir;

/**
 * ComuneSeeder - Popola i 7900+ comuni italiani con geometrie GeoJSON.
 *
 * Fonte dati: https://github.com/guglielmo/geojson-italy
 * File: geojson/limits_IT_municipalities.geojson (~40MB)
 *
 * Include: tutti i comuni con codici ISTAT, catastali, CAP, coordinate, geometrie
 * I dati vengono salvati in config/{tenant}/database/content/comuni.json
 *
 * ATTENZIONE: Il file GeoJSON è ~40MB. Il download può richiedere tempo.
 * Si consiglia di usare la cache locale (storage/app/geo-cache/).
 */
class ComuneSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('ComuneSeeder: download dati comuni italiani (file ~40MB)...');

        $downloader = new GeoJsonDownloader();

        // Processa a batch per gestire memoria
        $batchSize = 1000;
        $jsonData = [];
        $count = 0;

        $municipalities = $downloader->extractMunicipalities();

        if (empty($municipalities)) {
            $this->command?->error('ComuneSeeder: nessun dato comune trovato');

            return;
        }

        $total = count($municipalities);
        $this->command?->info("ComuneSeeder: trovati {$total} comuni");

        foreach ($municipalities as $municipality) {
            $jsonData[] = [
                'id' => $municipality['id'],
                'istat_code' => $municipality['istat_code'],
                'catasto_code' => $municipality['catasto_code'],
                'name' => $municipality['name'],
                'op_id' => $municipality['op_id'],
                'opdm_id' => $municipality['opdm_id'],
                'province_id' => $municipality['province_id'],
                'province_istat_code' => $municipality['province_istat_code'],
                'province_acronym' => $municipality['province_acronym'],
                'province_name' => $municipality['province_name'],
                'province_uts_code' => $municipality['province_uts_code'],
                'province_type' => $municipality['province_type'],
                'region_id' => $municipality['region_id'],
                'region_istat_code' => $municipality['region_istat_code'],
                'region_name' => $municipality['region_name'],
                'minint_elettorale' => $municipality['minint_elettorale'],
                'minint_finloc' => $municipality['minint_finloc'],
                'geometry' => $municipality['geometry'],
                'centroid' => $municipality['centroid'],
                'bbox' => $municipality['bbox'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];

            ++$count;

            // Salva batch intermedi per evitare problemi di memoria
            if (0 === $count % $batchSize) {
                $this->command?->info("ComuneSeeder: processati {$count}/{$total} comuni...");
            }
        }

        // Salva su file JSON per tenant (SushiToJson pattern)
        $this->saveToTenantJson('comuni', $jsonData);

        // Esegue il seeding standard via xotSeedModelOnce
        xotSeedModelOnce(Comune::class);

        $this->command?->info("ComuneSeeder: completato - {$count} comuni salvati");
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

        $this->command?->info("ComuneSeeder: salvato {$table}.json in {$path} (".count($data).' record)');
    }
}
