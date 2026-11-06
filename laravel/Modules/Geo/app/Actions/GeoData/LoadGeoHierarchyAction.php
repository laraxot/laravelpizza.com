<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

use function Safe\json_decode;

use Spatie\QueueableAction\QueueableAction;

/**
 * Carica e espone gerarchia regioni/province/città da JSON comuni.
 *
 * Sostituisce GeoDataService.
 */
final class LoadGeoHierarchyAction
{
    use QueueableAction;

    /**
     * Regioni come mappa codice => nome.
     *
     * @return Collection<string, string>
     */
    public function executeRegions(): Collection
    {
        return Cache::remember(
            GeoDataConfig::CACHE_KEY_REGIONS,
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => $this->loadData()->mapWithKeys(
                static fn (array $region): array => [
                    SafeStringCastAction::cast($region['code'] ?? '') => SafeStringCastAction::cast($region['name'] ?? ''),
                ],
            ),
        );
    }

    /**
     * @return Collection<int, array{name: string, code: string}>
     */
    public function executeProvinces(string $regionCode): Collection
    {
        return Cache::remember(
            sprintf(GeoDataConfig::CACHE_KEY_PROVINCES, $regionCode),
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => $this->loadProvinces($regionCode),
        );
    }

    /**
     * Città della provincia come mappa codice => nome.
     *
     * @return Collection<string, string>
     */
    public function executeCities(string $provinceCode): Collection
    {
        return Cache::remember(
            sprintf(GeoDataConfig::CACHE_KEY_CITIES, $provinceCode),
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => $this->loadCities($provinceCode),
        );
    }

    public function executeCap(string $provinceCode, string $cityCode): ?string
    {
        $cacheKey = sprintf(GeoDataConfig::CACHE_KEY_CAP, $provinceCode, $cityCode);

        /** @var string|null $result */
        $result = Cache::remember($cacheKey, GeoDataConfig::CACHE_TTL, function () use ($provinceCode, $cityCode): ?string {
            /** @var array<string, mixed>|null $province */
            $province = $this->loadData()->flatMap(static fn (array $region): array => is_array($region['provinces'] ?? null)
                ? $region['provinces']
                : [])->firstWhere('code', $provinceCode);

            if (! $province || ! is_array($province) || ! isset($province['cities']) || ! is_array($province['cities'])) {
                return null;
            }

            /** @var array<int, array<string, mixed>> $cities */
            $cities = $province['cities'];

            /** @var array<string, mixed>|null $city */
            $city = (new Collection($cities))->firstWhere('code', $cityCode);

            return is_array($city) && isset($city['cap']) && is_string($city['cap']) ? $city['cap'] : null;
        });

        return $result;
    }

    public function executeClearCache(): void
    {
        Cache::forget(GeoDataConfig::CACHE_KEY_REGIONS);
    }

    /**
     * @return Collection<int, array{name: string, code: string}>
     */
    private function loadProvinces(string $regionCode): Collection
    {
        /** @var array<string, mixed>|null $region */
        $region = $this->loadData()->firstWhere('code', $regionCode);

        if (! $region || ! is_array($region) || ! isset($region['provinces']) || ! is_array($region['provinces'])) {
            return new Collection();
        }

        /** @var array<int, array<string, mixed>> $provinces */
        $provinces = $region['provinces'];

        return (new Collection($provinces))
            ->map(static function (array $province): array {
                $name = $province['name'] ?? '';
                $code = $province['code'] ?? '';

                return [
                    'name' => SafeStringCastAction::cast($name),
                    'code' => SafeStringCastAction::cast($code),
                ];
            })
            ->values();
    }

    /**
     * @return Collection<string, string>
     */
    private function loadCities(string $provinceCode): Collection
    {
        /** @var array<string, mixed>|null $province */
        $province = $this->loadData()->flatMap(static fn (array $region): array => is_array($region['provinces'] ?? null)
            ? $region['provinces']
            : [])->firstWhere('code', $provinceCode);

        if (! $province || ! is_array($province) || ! isset($province['cities']) || ! is_array($province['cities'])) {
            return new Collection();
        }

        /** @var array<int, array<string, mixed>> $cities */
        $cities = $province['cities'];

        /** @var Collection<string, string> $cityResult */
        $cityResult = (new Collection($cities))->pluck('name', 'code');

        return $cityResult;
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function loadData(): Collection
    {
        if (! File::exists(base_path(GeoDataConfig::JSON_PATH))) {
            throw new \RuntimeException('Il file JSON dei comuni non esiste');
        }

        /** @var array<string, mixed> $data */
        $data = json_decode(File::get(base_path(GeoDataConfig::JSON_PATH)), true);

        if (! is_array($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! app(ValidateGeoDataIntegrityAction::class)->execute($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! isset($data['regions']) || ! is_array($data['regions'])) {
            throw new \RuntimeException('Regioni mancanti nel file JSON');
        }

        /** @var array<int, array<string, mixed>> $regions */
        $regions = $data['regions'];

        return (new Collection($regions))->values();
    }
}
