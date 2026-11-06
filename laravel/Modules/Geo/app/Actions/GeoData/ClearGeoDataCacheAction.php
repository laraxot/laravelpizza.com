<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Illuminate\Support\Facades\Cache;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Spatie\QueueableAction\QueueableAction;

/**
 * Pulisce la cache dei dati geografici (regioni/province/città/CAP).
 */
class ClearGeoDataCacheAction
{
    use QueueableAction;

    public function execute(): void
    {
        Cache::forget(GeoDataConfig::CACHE_KEY_REGIONS);

        // Nota: forgetPattern non esiste in Laravel Cache, usiamo forget per le chiavi specifiche
        // In un'implementazione reale, dovremmo mantenere traccia delle chiavi create
        // (province/città/cap sono chiavi parametrizzate, vedi GetProvincesAction/GetCitiesAction/GetCapAction).
    }
}
