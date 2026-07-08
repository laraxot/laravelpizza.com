<?php

declare(strict_types=1);

namespace Modules\Sigma\Datas;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

/**
 * Parametri filtro per calcoli giorni presenza/assenza (FunctionExtra).
 *
 * `lista_tipo_codice` in input può essere array (da getListaTipoCodiceAspettative)
 * o stringa CSV per find_in_set su concat(asztip,"-",aszcod).
 */
class GgFilterData extends Data
{
    public ?string $lista_propro = null;

    public ?string $lista_propro_sup = null;

    public ?string $posfun = null;

    public ?string $posiz = null;

    public ?Carbon $date_min = null;

    public ?Carbon $date_max = null;

    public ?string $lista_tipo_codice = null;

    /**
     * Converte array tipo-codice (es. ['505-97', '506-12']) in CSV per find_in_set.
     */
    public static function normalizeListaTipoCodice(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return $value === '' ? null : $value;
        }

        if (! is_array($value)) {
            return null;
        }

        $parts = [];
        foreach ($value as $item) {
            if (is_string($item) && $item !== '') {
                $parts[] = $item;
            }
        }

        return $parts === [] ? null : implode(',', $parts);
    }

    /**
     * @param  array<string, mixed>  $properties
     * @return array<string, mixed>
     */
    public static function prepareForPipeline(array $properties): array
    {
        if (array_key_exists('lista_tipo_codice', $properties)) {
            $properties['lista_tipo_codice'] = self::normalizeListaTipoCodice($properties['lista_tipo_codice']);
        }

        /** @var array<string, mixed> $result */
        $result = parent::prepareForPipeline($properties);

        return $result;
    }
}
