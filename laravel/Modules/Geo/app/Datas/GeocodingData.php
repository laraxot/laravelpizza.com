<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * DTO per i dati di geocodifica di un indirizzo.
 */
class GeocodingData extends Data
{
    public function __construct(
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $formatted_address,
        public readonly ?string $street_number,
        public readonly ?string $route,
        public readonly ?string $locality,
        public readonly ?string $administrative_area,
        public readonly ?string $country,
        public readonly ?string $postal_code,
        public readonly ?string $error = null,
    ) {}

    /**
     * Crea un'istanza di errore.
     */
    public static function error(string $error): self
    {
        return new self(
            latitude: null,
            longitude: null,
            formatted_address: null,
            street_number: null,
            route: null,
            locality: null,
            administrative_area: null,
            country: null,
            postal_code: null,
            error: $error,
        );
    }

    /**
     * Crea un'istanza dai dati della risposta di Google Maps.
     *
     * @param array{
     *     status: string,
     *     results: array<array{
     *         geometry: array{
     *             location: array{
     *                 lat: float,
     *                 lng: float
     *             }
     *         },
     *         formatted_address: string,
     *         address_components: array<array{
     *             long_name: string,
     *             short_name: string,
     *             types: array<string>
     *         }>
     *     }>
     * } $response
     */
    public static function fromGoogleResponse(array $response): self
    {
        $result = $response['results'][0];
        $location = $result['geometry']['location'];
        $components = self::extractAddressComponents($result['address_components']);

        return new self(
            latitude: $location['lat'],
            longitude: $location['lng'],
            formatted_address: $result['formatted_address'],
            street_number: $components['street_number'] ?? null,
            route: $components['route'] ?? null,
            locality: $components['locality'] ?? null,
            administrative_area: $components['administrative_area_level_1'] ?? null,
            country: $components['country'] ?? null,
            postal_code: $components['postal_code'] ?? null,
        );
    }

    /**
     * Estrae i componenti dell'indirizzo dalla risposta di Google Maps.
     *
     * @param array<array{
     *     long_name: string,
     *     short_name: string,
     *     types: array<string>
     * }> $components
     * @return array<string, string>
     */
    private static function extractAddressComponents(array $components): array
    {
        $result = [];

        foreach ($components as $component) {
            foreach ($component['types'] as $type) {
                $result[$type] = $component['long_name'];
            }
        }

        return $result;
    }
}
