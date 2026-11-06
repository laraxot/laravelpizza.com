<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ottiene tutte le regioni italiane (cache 24h).
 */
class GetRegionsAction
{
    use QueueableAction;

    /**
     * Regioni come mappa codice => nome.
     *
     * @return Collection<string, string>
     */
    public function execute(): Collection
    {
        return Cache::remember(
            GeoDataConfig::CACHE_KEY_REGIONS,
            GeoDataConfig::CACHE_TTL,
            fn (): Collection => app(LoadGeoDataAction::class)->execute()->mapWithKeys(
                static fn (array $region): array => [
                    SafeStringCastAction::cast($region['code'] ?? '') => SafeStringCastAction::cast($region['name'] ?? ''),
                ],
            ),
        );
    }
}
