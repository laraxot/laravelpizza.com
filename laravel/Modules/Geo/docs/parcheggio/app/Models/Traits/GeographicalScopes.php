<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
<<<<<<< .merge_file_v1y1ok
<<<<<<< .merge_file_MwVQx9

=======
>>>>>>> .merge_file_BMiXWR
=======
>>>>>>> .merge_file_zwEbSW
trait GeographicalScopes
{
    /**
     * Scope per calcolare la distanza (km, Haversine) da un punto: espone la colonna `distance`.
     *
     * `*` si aggiunge solo se la query non ha gia' colonne: `*, expr` dopo altre colonne e' un syntax error
     * su MariaDB (stessa regola di GeoTrait::scopeWithDistance).
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeWithDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        $prefix = empty($query->getQuery()->columns) ? '*, ' : '';

        return $query->selectRaw(
            $prefix.$this->distanceSql().' AS distance',
            [$latitude, $longitude, $latitude],
        );
    }

    /**
     * Scope per ordinare i risultati per distanza da un punto.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOrderByDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->orderByRaw($this->distanceSql(), [$latitude, $longitude, $latitude]);
    }

    /**
     * Formula di Haversine con tre segnaposto (latitudine, longitudine, latitudine): i valori vanno
     * sempre passati come binding, mai interpolati nel testo SQL.
     *
     * @return literal-string
     */
    protected function distanceSql(): string
    {
        return '6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))';

    }
}
