<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

trait GeographicalScopes
{
    /**
     * Scope per calcolare la distanza tra due punti.
     */
    public function scopeWithDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->select('*', $this->getDistanceExpression($latitude, $longitude, 'distance'));
    }

    /**
     * Scope per ordinare i risultati per distanza.
     */
    public function scopeOrderByDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->orderBy($this->getDistanceExpression($latitude, $longitude));
    }

    public function getDistanceExpression(
        float $latitude,
        float $longitude,
        ?string $alias = null,
    ): Expression|\Illuminate\Contracts\Database\Query\Expression {
        $sql = "
            (6371 * acos(
                cos(radians({$latitude})) *
                cos(radians(latitude)) *
                cos(radians(longitude) - radians({$longitude})) +
                sin(radians({$latitude})) *
                sin(radians(latitude))
            ))
        ";
        if ($alias !== null) {
            $sql .= " AS {$alias}";
        }

        return new Expression($sql);

        // AS distance
    }
}
