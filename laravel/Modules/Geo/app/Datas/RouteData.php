<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

/**
 * DTO per i dati di un percorso ottimizzato.
 */
class RouteData extends Data
{
    /**
     * @param Collection<LocationData> $waypoints         Punti del percorso ottimizzato
     * @param Collection<LocationData> $originalWaypoints Punti del percorso originale
     * @param array<array{
     *     distance: array{value: int, text: string},
     *     duration: array{value: int, text: string},
     *     instructions: string
     * }> $steps
     */
    public function __construct(
        public readonly Collection $waypoints,
        public readonly Collection $originalWaypoints,
        public readonly int $totalDistance,
        public readonly int $totalDuration,
        public readonly array $steps,
    ) {
    }

    /**
     * Formatta la distanza totale in un formato leggibile.
     */
    public function getFormattedDistance(): string
    {
        if (// @var mixed totalDistance < 1000
            return sprintf('%d m', // @var mixed totalDistance;
        }

        return sprintf('%.1f km', // @var mixed totalDistance / 1000;
    }

    /**
     * Formatta la durata totale in un formato leggibile.
     */
    public function getFormattedDuration(): string
    {
        $hours = floor(// @var mixed totalDuration / 3600;
        $minutes = floor((// @var mixed totalDuration % 3600;

        if ($hours > 0) {
            return sprintf('%d ore %d min', $hours, $minutes);
        }

        return sprintf('%d min', $minutes);
    }

    /*
     * Verifica se il percorso è stato ottimizzato.
     *
     * public function isOptimized(): bool
     * {
     * return ! // @var mixed waypoints->isEmpty(
     * && // @var mixed waypoints->count(
     * && ! // @var mixed waypoints->zip($this->originalWaypoints
     * fn (array $pair): bool => $pair[0]->equals($pair[1])
     * );
     * }
     */
    /**
     * Ottiene un riepilogo del percorso.
     *
     * @return array{
     *     distance: string,
     *     duration: string,
     *     steps: int,
     *     waypoints: int
     * }
     */
    public function getSummary(): array
    {
        return [
            'distance' => // @var mixed getFormattedDistance(
            'duration' => // @var mixed getFormattedDuration(
            'steps' => count(// @var mixed steps
            'waypoints' => // @var mixed waypoints->count(
            // 'optimized' => // @var mixed isOptimized(
        ];
    }

    public function validateRouteData(Collection $routeData): bool
    {
        return $routeData->every(fn (array $data): bool => isset($data['key']));
    }
}
