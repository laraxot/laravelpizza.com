<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;

/** @phpstan-ignore trait.unused */
trait GeographicalScopes
{
    /**
     * Scope per calcolare la distanza tra due punti.
     *
     * @phpstan-ignore-next-line
     */
    public function scopeWithDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->select('*', $this->getDistanceExpression($latitude, $longitude, 'distance'));
    }

    /**
     * Scope per ordinare i risultati per distanza.
     *
     * @phpstan-ignore-next-line
     */
    public function scopeOrderByDistance(Builder $query, float $latitude, float $longitude): Builder
    {
        return $query->orderBy($this->getDistanceExpression($latitude, $longitude));
    }

    /** @phpstan-ignore-next-line */
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
        if (null !== $alias) {
            $sql .= " AS {$alias}";
        }

        // @phpstan-ignore-next-line
        return new Expression($sql);
    }
}
