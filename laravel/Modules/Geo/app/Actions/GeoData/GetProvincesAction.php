<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene le province di una regione (cache 24h).
 */
class GetProvincesAction
{
    use QueueableAction;

    /**
     * @param string $regionCode Codice della regione
     *
     * @return Collection<int, array{name: string, code: string}>
     */
    public function execute(string $regionCode): Collection
    {
        $cacheKey = \sprintf(GeoDataConfig::CACHE_KEY_PROVINCES, $regionCode);

        /** @var Collection<int, array{name: string, code: string}> $result */
        $result = Cache::remember($cacheKey, GeoDataConfig::CACHE_TTL, function () use ($regionCode): Collection {
            /** @var array<string, mixed>|null $region */
            $region = app(LoadGeoDataAction::class)->execute()->firstWhere('code', $regionCode);

            if (! $region || ! \is_array($region) || ! isset($region['provinces']) || ! \is_array($region['provinces'])) {
                /** @var Collection<int, array{name: string, code: string}> $empty */
                $empty = new Collection();

                return $empty;
            }

            /** @var array<int, array<string, mixed>> $provinces */
            $provinces = $region['provinces'];

            /** @var Collection<int, array<string, mixed>> $provincesCollection */
            $provincesCollection = new Collection($provinces);

            /** @var Collection<int, array{name: string, code: string}> $provinceResult */
            $provinceResult = $provincesCollection
                ->map(static function (array $province): array {
                    $name = $province['name'] ?? '';
                    $code = $province['code'] ?? '';

                    return [
                        'name' => SafeStringCastAction::cast($name),
                        'code' => SafeStringCastAction::cast($code),
                    ];
                })
                ->values();

            return $provinceResult;
        });

        return $result;
    }
}
