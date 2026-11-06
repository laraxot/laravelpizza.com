<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene il CAP di una città (cache 24h).
 */
class GetCapAction
{
    use QueueableAction;

    /**
     * @param string $provinceCode Codice della provincia
     * @param string $cityCode     Codice della città
     */
    public function execute(string $provinceCode, string $cityCode): ?string
    {
        $cacheKey = \sprintf(GeoDataConfig::CACHE_KEY_CAP, $provinceCode, $cityCode);

        /** @var string|null $result */
        $result = Cache::remember($cacheKey, GeoDataConfig::CACHE_TTL, function () use ($provinceCode, $cityCode): ?string {
            /** @var array<string, mixed>|null $province */
            $province = app(LoadGeoDataAction::class)->execute()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
                ? $region['provinces']
                : [])->firstWhere('code', $provinceCode);

            if (! $province || ! \is_array($province) || ! isset($province['cities']) || ! \is_array($province['cities'])) {
                return null;
            }

            /** @var array<int, array<string, mixed>> $cities */
            $cities = $province['cities'];

            /** @var Collection<int, array<string, mixed>> $cityCollection */
            $cityCollection = new Collection($cities);

            /** @var array<string, mixed>|null $city */
            $city = $cityCollection->firstWhere('code', $cityCode);

            return \is_array($city) && isset($city['cap']) && \is_string($city['cap']) ? $city['cap'] : null;
        });

        return $result;
    }
}
