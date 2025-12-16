<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

use function Safe\json_decode;

/**
 * Servizio per la gestione dei dati geografici.
 *
 * Questo servizio fornisce metodi per accedere e manipolare i dati geografici
 * memorizzati nel file JSON.
 *
 * @see \Modules\Geo\docs\json-database.md
 */
class GeoDataService
{
    /**
     * Chiavi di cache.
     */
    private const CACHE_KEY_REGIONS = 'geo.regions';

    private const CACHE_KEY_PROVINCES = 'geo.provinces.%s';

    private const CACHE_KEY_CITIES = 'geo.cities.%s';

    private const CACHE_KEY_CAP = 'geo.cap.%s.%s';

    /**
     * Tempo di cache in secondi (24 ore).
     */
    private const CACHE_TTL = 86400;

    /**
     * Percorso del file JSON.
     */
    private const JSON_PATH = 'Modules/Geo/resources/json/comuni.json';

    /**
     * Validatore dei dati.
     */
    private GeoDataValidator $validator;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        $this->validator = new GeoDataValidator;
    }

    /**
     * Ottiene tutte le regioni.
     *
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getRegions(): Collection
    {
        /** @var Collection<int, array{name: string, code: string}> $result */
        $result = Cache::remember(
            self::CACHE_KEY_REGIONS,
            self::CACHE_TTL,
            fn (): Collection => $this->loadData()->pluck('name', 'code'),
        );

        return $result;
    }

    /**
     * Ottiene le province di una regione.
     *
     * @param  string  $regionCode  Codice della regione
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getProvinces(string $regionCode): Collection
    {
        $cacheKey = \sprintf(self::CACHE_KEY_PROVINCES, $regionCode);

        /** @var Collection<int, array{name: string, code: string}> $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($regionCode): Collection {
            /** @var array<string, mixed>|null $region */
            $region = $this->loadData()->firstWhere('code', $regionCode);

            if (! $region || ! \is_array($region) || ! isset($region['provinces']) || ! \is_array($region['provinces'])) {
                /* @var Collection<int, array{name: string, code: string}> */
                return new Collection;
            }

            /** @var array<int, array<string, mixed>> $provinces */
            $provinces = $region['provinces'];

            /** @var Collection<int, array<string, mixed>> $provincesCollection */
            $provincesCollection = new Collection($provinces);

            /** @var Collection<string, string> $provinceResult */
            $provinceResult = $provincesCollection->pluck('name', 'code');

            return $provinceResult;
        });

        return $result;
    }

    /**
     * Ottiene le città di una provincia.
     *
     * @param  string  $provinceCode  Codice della provincia
     * @return Collection<int, array{name: string, code: string}>
     */
    public function getCities(string $provinceCode): Collection
    {
        $cacheKey = \sprintf(self::CACHE_KEY_CITIES, $provinceCode);

        /** @var Collection<int, array{name: string, code: string}> $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($provinceCode): Collection {
            /** @var array<string, mixed>|null $province */
            $province = $this->loadData()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
                ? $region['provinces']
                : [])->firstWhere('code', $provinceCode);

            if (! $province || ! \is_array($province) || ! isset($province['cities']) || ! \is_array($province['cities'])) {
                /* @var Collection<int, array{name: string, code: string}> */
                return new Collection;
            }

            /** @var array<int, array<string, mixed>> $cities */
            $cities = $province['cities'];

            /** @var Collection<int, array<string, mixed>> $citiesCollection */
            $citiesCollection = new Collection($cities);

            /** @var Collection<string, string> $cityResult */
            $cityResult = $citiesCollection->pluck('name', 'code');

            return $cityResult;
        });

        return $result;
    }

    /**
     * Ottiene il CAP di una città.
     *
     * @param  string  $provinceCode  Codice della provincia
     * @param  string  $cityCode  Codice della città
     */
    public function getCap(string $provinceCode, string $cityCode): ?string
    {
        $cacheKey = \sprintf(self::CACHE_KEY_CAP, $provinceCode, $cityCode);

        /** @var string|null $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($provinceCode, $cityCode): null|string {
            /** @var array<string, mixed>|null $province */
            $province = $this->loadData()->flatMap(static fn (array $region): array => \is_array($region['provinces'] ?? null)
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

    /**
     * Pulisce la cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY_REGIONS);

        // Nota: forgetPattern non esiste in Laravel Cache, usiamo forget per le chiavi specifiche
        // In un'implementazione reale, dovremmo mantenere traccia delle chiavi create
    }

    /**
     * Carica i dati dal file JSON.
     *
     *
     * @return Collection<int, array<string, mixed>>
     *
     * @throws \RuntimeException Se il file non esiste o non è valido
     */
    private function loadData(): Collection
    {
        if (! File::exists(base_path(self::JSON_PATH))) {
            throw new \RuntimeException('Il file JSON dei comuni non esiste');
        }

        /** @var array<string, mixed> $data */
        $data = json_decode(File::get(base_path(self::JSON_PATH)), true);

        if (! \is_array($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! $this->validator->checkIntegrity($data)) {
            throw new \RuntimeException('Il file JSON dei comuni non è valido');
        }

        if (! isset($data['regions']) || ! \is_array($data['regions'])) {
            throw new \RuntimeException('Regioni mancanti nel file JSON');
        }

        /** @var Collection<int, array<string, mixed>> $result */
        $result = new Collection($data['regions']);

        return $result;
    }
}
