<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

use function Safe\file_get_contents;
use function Safe\json_decode;

/**
 * Base model readonly per dati geografici statici (ispirato a Squire).
 * Carica e cache-izza i dati da json.
 */
abstract class GeoJsonModel
{
    /**
     * Percorso relativo al file json (da ridefinire nelle sottoclassi se necessario).
     */
    protected static string $jsonFile = 'resources/json/comuni.json';

    /**
     * Restituisce tutti i dati come collection.
     */
    public static function all(): Collection
    {
        return static::loadData();
    }

    /**
     * Filtra la collection per chiave/valore.
     *
     * @param string $key
     * @param string|int|bool|null $value
     * @return Collection<int, array<string, mixed>>
     */
    public static function where(string $key, $value): Collection
    {
        /** @var Collection<int, array<string, mixed>> $all */
        $all = static::all();
        
        return $all->where($key, $value);
    }

    /**
     * Carica e cache-izza i dati dal file json.
     * 
     * @return Collection<int, array<string, mixed>>
     */
    protected static function loadData(): Collection
    {
        $path = module_path('Geo', static::$jsonFile);
        $cacheKey = 'geo_comuni_json_'.md5($path);
        
        /** @var array<int, array<string, mixed>>|mixed $data */
        $data = cache()->rememberForever($cacheKey, fn () => json_decode(file_get_contents($path), true));

        if (! is_array($data)) {
            /** @var Collection<int, array<string, mixed>> $emptyResult */
            $emptyResult = collect();
            return $emptyResult;
        }

        /** @var Collection<int, array<string, mixed>> $result */
        $result = collect($data)->values();

        return $result;
    }
}
