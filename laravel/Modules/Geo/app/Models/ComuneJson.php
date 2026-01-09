<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Modello unico readonly per i comuni italiani (Facade pattern).
 *
 * Implementa il pattern Facade per fornire un'interfaccia unificata a tutti i dati geografici:
 * regioni, province, città, CAP, codici ISTAT, ecc.
 * Tutti i dati sono estratti da un'unica fonte (comuni.json) e gestiti tramite metodi statici.
 * Include un sistema di caching multilivello per ottimizzare le performance.
 *
 * @see GeoJsonModel Classe base per l'accesso ai dati JSON
 * @see docs/consolidamento-modelli-geografici.md Analisi comparativa della struttura
 * @see docs/comune-unificazione-analisi.md Analisi dell'unificazione dei modelli
 * @see docs/geo-json-model.md Documentazione tecnica del modello base
 */
/**
 * @mixin Builder
 */
class ComuneJson extends GeoJsonModel
{
    /**
     * Cache duration in seconds (1 week).
     */
    protected const CACHE_TTL = 604800;

    /**
     * Get all comuni with their complete data.
     *
     * @return Collection<int, array{
     *     nome: string,
     *     codice: string,
     *     regione: array{codice: string, nome: string},
     *     provincia: array{codice: string, nome: string},
     *     cap: array<int, string>,
     *     codiceCatastale: string,
     *     popolazione: int
     * }>
     */
    #[\Override]
    public static function all(): Collection
    {
        /** @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $all */
        $all = static::loadData();

        return $all;
    }

    /**
     * Get comuni by region code.
     *
     * @return Collection<int, array{
     *     nome: string,
     *     codice: string,
     *     regione: array{codice: string, nome: string},
     *     provincia: array{codice: string, nome: string},
     *     cap: array<int, string>,
     *     codiceCatastale: string,
     *     popolazione: int
     * }>
     */
    public static function byRegion(string $regionCode): Collection
    {
        $cacheKey = "geo_region_{$regionCode}";

        /* @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, static function () use ($regionCode) {
            return static::all()
                ->where('regione.codice', $regionCode)
                ->sortBy('nome')
                ->values();
        });

        /* @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $result */
        return $result;
    }

    /**
     * Get comuni by province code.
     *
     * @return Collection<int, array{
     *     nome: string,
     *     codice: string,
     *     regione: array{codice: string, nome: string},
     *     provincia: array{codice: string, nome: string},
     *     cap: array<int, string>,
     *     codiceCatastale: string,
     *     popolazione: int
     * }>
     */
    public static function byProvince(string $provinceCode): Collection
    {
        $cacheKey = "geo_province_{$provinceCode}";

        /* @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, static function () use ($provinceCode) {
            return static::all()
                ->where('provincia.codice', $provinceCode)
                ->sortBy('nome')
                ->values();
        });

        /* @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $result */
        return $result;
    }

    /**
     * Get all comuni by name (case insensitive partial match).
     *
     * @param string $name  Nome parziale del comune da cercare
     * @param int    $limit Numero massimo di risultati (0 = nessun limite)
     *
     * @return Collection<int, array{
     *     nome: string,
     *     codice: string,
     *     regione: array{codice: string, nome: string},
     *     provincia: array{codice: string, nome: string},
     *     cap: array<int, string>,
     *     codiceCatastale: string,
     *     popolazione: int
     * }> Comuni che corrispondono alla ricerca
     */
    public static function searchByName(string $name, int $limit = 0): Collection
    {
        $name = mb_strtolower($name);
        $cacheKey = 'geo_search_'.md5($name).'_'.$limit;

        $result = Cache::remember($cacheKey, self::CACHE_TTL, static function () use ($name, $limit) {
            $results = static::all()
                /* @phpstan-ignore nullCoalesce.offset */
                ->filter(static fn ($item) => str_contains(mb_strtolower($item['nome'] ?? ''), $name))
                ->sortBy('nome');

            return $limit > 0 ? $results->take($limit)->values() : $results->values();
        });

        /* @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $result */
        return $result;
    }

    /**
     * Get comuni by CAP.
     *
     * @return Collection<int, array{
     *     nome: string,
     *     codice: string,
     *     regione: array{codice: string, nome: string},
     *     provincia: array{codice: string, nome: string},
     *     cap: array<int, string>,
     *     codiceCatastale: string,
     *     popolazione: int
     * }>
     */
    public static function byCap(string $cap): Collection
    {
        /** @var Collection<int, array{
         *     nome: string,
         *     codice: string,
         *     regione: array{codice: string, nome: string},
         *     provincia: array{codice: string, nome: string},
         *     cap: array<int, string>,
         *     codiceCatastale: string,
         *     popolazione: int
         * }> $filtered */
        $filtered = static::all()
            /* @phpstan-ignore nullCoalesce.offset */
            ->filter(static fn ($item) => \in_array($cap, $item['cap'] ?? [], true))
            ->sortBy('nome')
            ->values();

        return $filtered;
    }

    /**
     * Get all regions with their codes and names.
     *
     * @return Collection<string, string> [code => name]
     */
    public static function allRegions(): Collection
    {
        /** @var Collection<string, string> $result */
        $result = Cache::remember('geo_all_regions', self::CACHE_TTL, static::all()
            ->pluck('regione.nome', 'regione.codice')
            ->unique()
            ->sort(...));

        return $result;
    }

    /**
     * Get all provinces with their codes and names.
     *
     * @return Collection<string, string> [code => name]
     */
    public static function allProvinces(): Collection
    {
        /** @var Collection<string, string> $result */
        $result = Cache::remember('geo_all_provinces', self::CACHE_TTL, static::all()
            ->pluck('provincia.nome', 'provincia.codice')
            ->unique()
            ->sort(...));

        return $result;
    }

    /**
     * Get all provinces for a specific region.
     *
     * @return Collection<string, string> [code => name]
     */
    public static function getProvincesByRegion(string $regionCode): Collection
    {
        $cacheKey = "geo_region_{$regionCode}_provinces";

        /** @var Collection<string, string> $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, static::all()
            ->where('regione.codice', $regionCode)
            ->pluck('provincia.nome', 'provincia.codice')
            ->unique()
            ->sort(...));

        return $result;
    }

    /**
     * Get all CAPs for a specific city.
     *
     * @return Collection<int, string> List of CAP codes for the city
     */
    public static function getCapsByCity(string $cityName): Collection
    {
        /** @var Collection<int, string> $result */
        $result = static::all()
            ->where('nome', $cityName)
            ->pluck('cap')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return $result;
    }

    /**
     * Clear all cached data.
     *
     * @param bool $verbose Se true, restituisce la lista delle chiavi di cache eliminate
     *
     * @return array<int, string>|null Lista delle chiavi di cache eliminate se $verbose è true
     */
    public static function clearCache(bool $verbose = false): ?array
    {
        $clearedKeys = [];

        // Chiavi base
        $baseKeys = ['geo_all_regions', 'geo_all_provinces'];
        foreach ($baseKeys as $key) {
            Cache::forget($key);
            $clearedKeys[] = $key;
        }

        // Chiavi specifiche per regione
        static::allRegions()
            ->each(static function ($_nome, $code) use (&$clearedKeys): void {
                $keys = ["geo_region_{$code}", "geo_region_{$code}_provinces"];
                foreach ($keys as $key) {
                    Cache::forget($key);
                    $clearedKeys[] = $key;
                }
            });

        // Chiavi specifiche per provincia
        static::allProvinces()
            ->each(static function ($_nome, $code) use (&$clearedKeys): void {
                $key = "geo_province_{$code}";
                Cache::forget($key);
                $clearedKeys[] = $key;
            });

        // Nota: La pulizia delle chiavi di pattern matching è limitata
        // poiché non tutti i driver di cache supportano la ricerca per pattern
        // Le chiavi di ricerca più comuni vengono gestite esplicitamente
        $searchPatterns = [
            'geo_search_', // Ricerche generiche
            'geo_valid_cap_', // Validazione CAP
            'geo_gerarchia_', // Gerarchie geografiche
        ];

        // Puliamo alcune chiavi di ricerca comuni per essere sicuri
        foreach ($searchPatterns as $pattern) {
            for ($i = 0; $i < 10; ++$i) {
                $testKey = $pattern.md5((string) $i);
                Cache::forget($testKey);
            }
        }

        return $verbose ? $clearedKeys : null;
    }

    /**
     * Verifica se il CAP esiste nel database.
     *
     * @param string $cap CAP da verificare
     *
     * @return bool True se il CAP esiste, false altrimenti
     */
    public static function isValidCap(string $cap): bool
    {
        $cacheKey = "geo_valid_cap_{$cap}";

        /** @var bool $result */
        $result = Cache::remember($cacheKey, self::CACHE_TTL, static::byCap($cap)->isNotEmpty(...));

        return $result;
    }

    /**
     * Ottiene la gerarchia completa per un comune (regione, provincia, comune, cap).
     *
     * @param string $comuneNome Nome esatto del comune
     *
     * @return array{
     *     regione: array{codice: string, nome: string}|null,
     *     provincia: array{codice: string, nome: string}|null,
     *     comune: array{
     *         nome: string,
     *         codice: string|null,
     *         codiceCatastale: string|null,
     *         popolazione: int|null
     *     },
     *     cap: array<int, string>
     * }|null Gerarchia completa o null se il comune non esiste
     */
    public static function getGerarchia(string $comuneNome): ?array
    {
        $cacheKey = 'geo_gerarchia_'.md5($comuneNome);

        $result = Cache::remember($cacheKey, self::CACHE_TTL, static function () use ($comuneNome): ?array {
            /** @var array{
             *     nome: string,
             *     codice: string,
             *     regione: array{codice: string, nome: string},
             *     provincia: array{codice: string, nome: string},
             *     cap: array<int, string>,
             *     codiceCatastale: string,
             *     popolazione: int
             * }|null $comune */
            $comune = static::searchByName($comuneNome, 1)->first();

            if (! $comune) {
                return null;
            }

            $result = [
                'regione' => $comune['regione'] ?? null,
                'provincia' => $comune['provincia'] ?? null,
                'comune' => [
                    'nome' => $comune['nome'],
                    'codice' => $comune['codice'] ?? null,
                    'codiceCatastale' => $comune['codiceCatastale'] ?? null,
                    'popolazione' => $comune['popolazione'] ?? null,
                ],
                'cap' => $comune['cap'] ?? [],
            ];

            return $result;
        });

        /* @var array{
         *     regione: array{codice: string, nome: string}|null,
         *     provincia: array{codice: string, nome: string}|null,
         *     comune: array{
         *         nome: string,
         *         codice: string|null,
         *         codiceCatastale: string|null,
         *         popolazione: int|null
         *     },
         *     cap: array<int, string>
         * }|null $result */
        return $result;
    }

    /**
     * Restituisce regole di validazione Laravel per form geografici.
     *
     * @param bool $required Se true, tutti i campi sono obbligatori
     *
     * @return array<string, array<int, mixed>> Regole di validazione
     */
    public static function getValidationRules(bool $required = true): array
    {
        $requiredRule = $required ? 'required' : 'nullable';

        return [
            'regione_codice' => [
                $requiredRule,
                'string',
                static function ($_attribute, $value, $fail): void {
                    if (\is_string($value) && ! static::allRegions()->has($value)) {
                        /* @phpstan-ignore callable.nonCallable */
                        $fail('La regione selezionata non è valida.');
                    }
                },
            ],
            'provincia_codice' => [
                $requiredRule,
                'string',
                static function ($_attribute, $value, $fail): void {
                    if (\is_string($value) && ! static::allProvinces()->has($value)) {
                        /* @phpstan-ignore callable.nonCallable */
                        $fail('La provincia selezionata non è valida.');
                    }
                },
            ],
            'comune_nome' => [
                $requiredRule,
                'string',
                static function ($_attribute, $value, $fail): void {
                    if (\is_string($value) && ! empty($value) && static::searchByName($value, 1)->isEmpty()) {
                        /* @phpstan-ignore callable.nonCallable */
                        $fail('Il comune selezionato non è valido.');
                    }
                },
            ],
            'cap' => [
                $requiredRule,
                'string',
                static function ($_attribute, $value, $fail): void {
                    if (\is_string($value) && ! empty($value) && ! static::isValidCap($value)) {
                        /* @phpstan-ignore callable.nonCallable */
                        $fail('Il CAP inserito non è valido.');
                    }
                },
            ],
        ];
    }
}
