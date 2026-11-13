<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Webmozart\Assert\Assert;

/**
 * Distanza e scope geografici per modelli con colonne `latitude` / `longitude`.
 *
 * Perché: un solo punto per Haversine su Address (e consumer futuri), senza
 * mutator JSON legacy che collidono con accessor già definiti sui modelli.
 * SQL letterale + binding (come Address::scopeNearby) per tipizzare literal-string.
 *
 * @property float|null $latitude
 * @property float|null $longitude
 *
 * @phpstan-require-extends Model
 */
trait GeoTrait
{
    public function distance(?float $lat = null, ?float $lng = null): ?float
    {
        $distance = app(CalculateGeoDistanceAction::class)->execute(
            SafeFloatCastAction::cast($this->latitude),
            SafeFloatCastAction::cast($this->longitude),
            $lat,
            $lng,
            '',
        );

        return $distance !== null ? SafeFloatCastAction::cast($distance) : null;
    }

    public function distanceCustomField(
        string $lat_field,
        string $lng_field,
        ?float $lat = null,
        ?float $lng = null,
        ?string $unit = '',
    ): ?float {
        Assert::regex($lat_field, '/^[A-Za-z_][A-Za-z0-9_]*$/');
        Assert::regex($lng_field, '/^[A-Za-z_][A-Za-z0-9_]*$/');

        $latFromField = SafeFloatCastAction::cast($this->{$lat_field});
        $lngFromField = SafeFloatCastAction::cast($this->{$lng_field});

        $distance = app(CalculateGeoDistanceAction::class)->execute(
            $latFromField,
            $lngFromField,
            $lat,
            $lng,
            $unit,
        );

        return $distance !== null ? SafeFloatCastAction::cast($distance) : null;
    }

    /**
     * Espone `distance` come attributo (prodotto da `scopeWithDistance`)
     * invece di relation: senza questo accessor, `$model->distance` cada
     * nel ramo relation di Eloquent e `distance()` — che non e' una
     * relation — fa fallire il boot delle tabelle Filament.
     */
    public function getDistanceAttribute(mixed $value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * Ordina per distanza Haversine da un punto (colonna distance in select).
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeWithDistance(Builder $query, float $lat, float $lng): Builder
    {
        if (! is_finite($lat) || ! is_finite($lng) || abs($lat) > 90 || abs($lng) > 180) {
            return $query;
        }

        /*
         * `*` va aggiunto solo se la query non ha gia' colonne selezionate:
         * con `clients.*, <subselect>, *, 6371...` MariaDB rifiuta la sintassi.
         */
        $expression = '6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))) AS distance';
        $bindings = [$lat, $lng, $lat];
        $prefix = empty($query->getQuery()->columns) ? '*, ' : '';

        return $query
            ->selectRaw($prefix.$expression, $bindings)
            // Senza coords `distance` e' NULL: in MySQL gli NULL vengono
            // prima in ASC → i record senza coordinate_DOMINANO la lista.
            // `distance IS NULL` ordina 0/1: prima i calcolati, poi gli altri.
            ->orderByRaw('distance IS NULL')
            ->orderBy('distance');
    }

    /**
     * Filtra le righe il cui poligono JSON (`zone_polygon`) contiene il punto.
     *
     * L'SQL grezzo del progetto deve essere letterale (`literal-string`), quindi il nome della
     * colonna non si interpola: `zone_polygon` e' l'unica colonna supportata. Il parametro resta
     * per compatibilita' con i chiamanti; un'altra colonna e' un errore, non una query sbagliata.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOfInPolygon(Builder $query, string $polygon_field, float $lat, float $lng): Builder
    {
        Assert::same($polygon_field, 'zone_polygon', 'scopeOfInPolygon supporta solo la colonna zone_polygon.');

        return $query
            ->whereNotNull('zone_polygon')
            ->whereRaw(
                <<<'SQL'
                    ST_Contains(
                        ST_GeomFromText(
                            concat('POLYGON((',
                            REPLACE(
                            REPLACE(
                            REPLACE(
                            REPLACE(
                            replace(CONCAT(
                            replace(replace(JSON_extract(zone_polygon,'$'),']',''),'[',''),
                            ',',JSON_extract(zone_polygon,'$[0]'))
                            ,'"lat":','')
                            ,',"lng":',' ')
                            ,'{',' ')
                            ,', "lng":',' ')
                            ,'}','')
                            ,'))')
                        ), ST_GeomFromText(CONCAT('POINT(', ?, ' ', ?, ')'))
                    )
                    SQL,
                [$lat, $lng],
            );
    }
}
