<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i risultati del calcolo del tempo di percorrenza.
 *
 * Questo DTO contiene i dati relativi al tempo di percorrenza tra due punti,
 * inclusi durata, distanza e informazioni sul traffico.
 */
class TravelTimeData extends Data
{
    public function __construct(
        public readonly int $duration_seconds,
        public readonly int $duration_in_traffic_seconds,
        public readonly int $distance_meters,
        public readonly string $formatted_duration,
        public readonly string $formatted_distance,
        public readonly string $status = 'OK',
    ) {}

    /**
     * Crea un'istanza di errore.
     */
    public static function error(string $status = 'ERROR'): self
    {
        return new self(
            duration_seconds: 0,
            duration_in_traffic_seconds: 0,
            distance_meters: 0,
            formatted_duration: 'N/D',
            formatted_distance: 'N/D',
            status: $status,
        );
    }

    /**
     * Crea un'istanza dai dati della risposta di Google Maps.
     *
     * @param array{
     *     rows: array{
     *         0: array{
     *             elements: array{
     *                 0: array{
     *                     duration: array{value: int, text: string},
     *                     duration_in_traffic?: array{value: int, text: string},
     *                     distance: array{value: int, text: string},
     *                     status: string
     *                 }
     *             }
     *         }
     *     },
     *     status: string
     * } $response
     */
    public static function fromGoogleResponse(array $response): self
    {
        if ($response['status'] !== 'OK') {
            return self::error($response['status']);
        }

        $element = $response['rows'][0]['elements'][0] ?? null;
        if (! $element || ($element['status'] ?? null) !== 'OK') {
            return self::error($element['status'] ?? 'INVALID_RESPONSE');
        }

        return new self(
            duration_seconds: (int) $element['duration']['value'],
            duration_in_traffic_seconds: isset($element['duration_in_traffic'])
                ? ((int) $element['duration_in_traffic']['value'])
                : ((int) $element['duration']['value']),
            distance_meters: (int) $element['distance']['value'],
            formatted_duration: $element['duration']['text'],
            formatted_distance: $element['distance']['text'],
            status: $response['status'],
        );
    }
}
