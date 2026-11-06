<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Helper class to download and process GeoJSON data from openpolis/geojson-italy.
 */
class GeoJsonDownloader
{
    protected const string BASE_URL = 'https://raw.githubusercontent.com/guglielmo/geojson-italy/master/geojson';

    protected const string REGIONS_URL = self::BASE_URL.'/limits_IT_regions.geojson';

    protected const string MUNICIPALITIES_URL = self::BASE_URL.'/limits_IT_municipalities.geojson';

    protected const string PROVINCES_URL = self::BASE_URL.'/limits_IT_provinces.geojson';

    protected string $cacheDir;

    public function __construct()
    {
        $this->cacheDir = storage_path('app/geo-cache');
        if (! File::exists($this->cacheDir)) {
            File::makeDirectory($this->cacheDir, 0o755, true, true);
        }
    }

    /**
     * Download and parse regions GeoJSON.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRegions(): array
    {
        return $this->fetchAndParse(self::REGIONS_URL, 'regions.geojson');
    }

    /**
     * Download and parse provinces GeoJSON.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getProvinces(): array
    {
        return $this->fetchAndParse(self::PROVINCES_URL, 'provinces.geojson');
    }

    /**
     * Download and parse municipalities GeoJSON.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getMunicipalities(): array
    {
        return $this->fetchAndParse(self::MUNICIPALITIES_URL, 'municipalities.geojson');
    }

    /**
     * Fetch GeoJSON from URL with caching.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function fetchAndParse(string $url, string $cacheFile): array
    {
        $cachePath = $this->cacheDir.'/'.$cacheFile;

        if (File::exists($cachePath)) {
            $content = File::get($cachePath);

            return $this->featuresFromData(json_decode($content, true), $cacheFile);
        }

        $response = Http::timeout(120)->get($url);

        if (! $response->successful()) {
            throw new \Exception("Failed to download {$url}: {$response->status()}");
        }

        $data = $response->json();

        $features = $this->featuresFromData($data, $url);

        File::put($cachePath, json_encode($data, JSON_UNESCAPED_UNICODE));

        return $features;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function featuresFromData(mixed $data, string $source): array
    {
        if (! is_array($data) || ! isset($data['features']) || ! is_array($data['features'])) {
            throw new \Exception("Invalid GeoJSON structure from {$source}");
        }

        $features = [];
        foreach ($data['features'] as $feature) {
            if (is_array($feature)) {
                /** @var array<string, mixed> $feature */
                $features[] = $feature;
            }
        }

        return $features;
    }

    /**
     * Extract region data from features.
     *
     * @return array<int, array<string, mixed>>
     */
    public function extractRegions(): array
    {
        $features = $this->getRegions();
        $regions = [];

        foreach ($features as $feature) {
            if (! is_array($feature['properties'] ?? null) || ! is_array($feature['geometry'] ?? null)) {
                continue;
            }

            $props = $feature['properties'];
            $geometry = $feature['geometry'];
            /** @var array<string, mixed> $geometry */

            $regions[] = [
                'id' => $this->intValue($props['reg_istat_code_num'] ?? null),
                'istat_code' => $props['reg_istat_code'] ?? '',
                'iso_code' => $props['reg_iso_3166_2'] ?? '',
                'name' => $props['reg_name'] ?? '',
                'geometry' => $geometry,
                'bbox' => $feature['bbox'] ?? null,
            ];
        }

        usort($regions, fn (array $a, array $b): int => $a['id'] <=> $b['id']);

        return $regions;
    }

    /**
     * Extract province data from features.
     *
     * @return array<int, array<string, mixed>>
     */
    public function extractProvinces(): array
    {
        $features = $this->getProvinces();
        $provinces = [];

        foreach ($features as $feature) {
            if (! is_array($feature['properties'] ?? null) || ! is_array($feature['geometry'] ?? null)) {
                continue;
            }

            $props = $feature['properties'];
            $geometry = $feature['geometry'];

            $provinces[] = [
                'id' => $this->intValue($props['prov_istat_code_num'] ?? null),
                'istat_code' => $props['prov_istat_code'] ?? '',
                'uts_code' => $props['prov_uts_code'] ?? '',
                'iso_code' => $props['prov_iso_3166_2'] ?? '',
                'acronym' => $props['prov_acr'] ?? '',
                'name' => $props['prov_name'] ?? '',
                'type' => $props['prov_tipo_uts'] ?? '',
                'region_id' => $this->intValue($props['reg_istat_code_num'] ?? null),
                'region_istat_code' => $props['reg_istat_code'] ?? '',
                'region_name' => $props['reg_name'] ?? '',
                'geometry' => $geometry,
                'bbox' => $feature['bbox'] ?? null,
            ];
        }

        usort($provinces, fn (array $a, array $b): int => $a['id'] <=> $b['id']);

        return $provinces;
    }

    /**
     * Extract municipality data from features.
     *
     * @return array<int, array<string, mixed>>
     */
    public function extractMunicipalities(): array
    {
        $features = $this->getMunicipalities();
        $municipalities = [];

        foreach ($features as $feature) {
            if (! is_array($feature['properties'] ?? null) || ! is_array($feature['geometry'] ?? null)) {
                continue;
            }

            $props = $feature['properties'];
            $geometry = $feature['geometry'];
            /** @var array<string, mixed> $geometry */

            // Calculate centroid for point representation
            $centroid = $this->calculateCentroid($geometry);

            $municipalities[] = [
                'id' => $this->intValue($props['com_istat_code_num'] ?? null),
                'istat_code' => $props['com_istat_code'] ?? '',
                'catasto_code' => $props['com_catasto_code'] ?? '',
                'name' => $props['name'] ?? '',
                'op_id' => $props['op_id'] ?? '',
                'opdm_id' => $props['opdm_id'] ?? '',
                'province_id' => $this->intValue($props['prov_istat_code_num'] ?? null),
                'province_istat_code' => $props['prov_istat_code'] ?? '',
                'province_acronym' => $props['prov_acr'] ?? '',
                'province_name' => $props['prov_name'] ?? '',
                'province_uts_code' => $props['prov_uts_code'] ?? '',
                'province_type' => $props['prov_tipo_uts'] ?? '',
                'region_id' => $this->intValue($props['reg_istat_code_num'] ?? null),
                'region_istat_code' => $props['reg_istat_code'] ?? '',
                'region_name' => $props['reg_name'] ?? '',
                'minint_elettorale' => $props['minint_elettorale'] ?? '',
                'minint_finloc' => $props['minint_finloc'] ?? '',
                'geometry' => $geometry,
                'centroid' => $centroid,
                'bbox' => $feature['bbox'] ?? null,
            ];
        }

        usort($municipalities, fn (array $a, array $b): int => $a['id'] <=> $b['id']);

        return $municipalities;
    }

    /**
     * Calculate centroid of a geometry.
     *
     * @param array<string, mixed> $geometry
     *
     * @return array{lat: float, lng: float}|null
     */
    protected function calculateCentroid(array $geometry): ?array
    {
        $coords = $this->extractCoordinates($geometry);

        if (empty($coords)) {
            return null;
        }

        $sumLat = 0.0;
        $sumLng = 0.0;
        $count = 0;

        /** @var array<int, array{0: float, 1: float}> $coords */
        foreach ($coords as $coord) {
            $sumLng += $coord[0];
            $sumLat += $coord[1];
            ++$count;
        }

        return [
            'lat' => $sumLat / $count,
            'lng' => $sumLng / $count,
        ];
    }

    /**
     * Extract all coordinates from a geometry recursively.
     *
     * @param array<string, mixed> $geometry
     *
     * @return array<int, array{0: float, 1: float}>
     */
    protected function extractCoordinates(array $geometry): array
    {
        $type = $geometry['type'] ?? '';
        $coordinates = $geometry['coordinates'] ?? [];

        $result = [];

        switch ($type) {
            case 'Point':
                if (is_array($coordinates) && count($coordinates) >= 2 && is_numeric($coordinates[0]) && is_numeric($coordinates[1])) {
                    $result[] = [(float) $coordinates[0], (float) $coordinates[1]];
                }
                break;

            case 'LineString':
            case 'MultiPoint':
                foreach (is_array($coordinates) ? $coordinates : [] as $coord) {
                    if (is_array($coord) && count($coord) >= 2 && is_numeric($coord[0]) && is_numeric($coord[1])) {
                        $result[] = [(float) $coord[0], (float) $coord[1]];
                    }
                }
                break;

            case 'Polygon':
            case 'MultiLineString':
                foreach (is_array($coordinates) ? $coordinates : [] as $ring) {
                    if (is_array($ring)) {
                        foreach ($ring as $coord) {
                            if (is_array($coord) && count($coord) >= 2 && is_numeric($coord[0]) && is_numeric($coord[1])) {
                                $result[] = [(float) $coord[0], (float) $coord[1]];
                            }
                        }
                    }
                }
                break;

            case 'MultiPolygon':
                foreach (is_array($coordinates) ? $coordinates : [] as $polygon) {
                    if (is_array($polygon)) {
                        foreach ($polygon as $ring) {
                            if (is_array($ring)) {
                                foreach ($ring as $coord) {
                                    if (is_array($coord) && count($coord) >= 2 && is_numeric($coord[0]) && is_numeric($coord[1])) {
                                        $result[] = [(float) $coord[0], (float) $coord[1]];
                                    }
                                }
                            }
                        }
                    }
                }
                break;

            case 'GeometryCollection':
                if (isset($geometry['geometries']) && is_array($geometry['geometries'])) {
                    foreach ($geometry['geometries'] as $geom) {
                        if (is_array($geom)) {
                            /** @var array<string, mixed> $geom */
                            $result = array_merge($result, $this->extractCoordinates($geom));
                        }
                    }
                }
                break;
        }

        return $result;
    }

    private function intValue(mixed $value): int
    {
        return is_numeric($value) ? (int) $value : 0;
    }
}
