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
     * @phpstan-ignore missingType.parameter, missingType.generics
     */
    public static function where(string $key, $value): Collection
    {
        /*
         * @phpstan-ignore-next-line
         */
        return static::all()->where($key, $value);
    }

    /**
     * Carica e cache-izza i dati dal file json.
     */
    protected static function loadData(): Collection
    {
        $path = module_path('Geo', static::$jsonFile);
        $cacheKey = 'geo_comuni_json_'.md5($path);
        $data = cache()->rememberForever($cacheKey, fn () => json_decode(file_get_contents($path), true));

        /*
         * @phpstan-ignore argument.type, argument.templateType, argument.templateType
         */
        return collect($data);
    }
}
