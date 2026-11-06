<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene le città di una provincia (cache 24h).
 */
class GetCitiesAction
{
    use QueueableAction;

    /**
     * Città della provincia come mappa codice => nome.
     *
     * @param string $provinceCode Codice della provincia
     *
     * @return Collection<string, string>
     */
    public function execute(string $provinceCode): Collection
    {
        return Cache::remember(
            \sprintf(GeoDataConfig::CACHE_KEY_CITIES, $provinceCode),
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => $this->loadCities($provinceCode),
        );
    }

    /**
     * @return Collection<string, string>
     */
    private function loadCities(string $provinceCode): Collection
    {
        /** @var array<string, mixed>|null $province */
        $province = app(LoadGeoDataAction::class)->execute()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
            ? $region['provinces']
            : [])->firstWhere('code', $provinceCode);

        if (! $province || ! \is_array($province) || ! isset($province['cities']) || ! \is_array($province['cities'])) {
            return new Collection();
        }

        /** @var array<int, array<string, mixed>> $cities */
        $cities = $province['cities'];

        /** @var Collection<string, string> $cityResult */
        $cityResult = (new Collection($cities))->pluck('name', 'code');

        return $cityResult;
    }
}
