<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Bing;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Datas\BingMapData;
use Modules\Geo\Exceptions\InvalidLocationException;

/**
 * Classe per ottenere l'indirizzo da Bing Maps.
 */
class GetAddressFromBingMapsAction
{
    private const BASE_URL = 'http://dev.virtualearth.net/REST/v1/Locations';

    /**
     * Ottiene l'indirizzo da coordinate geografiche.
     *
     * @throws InvalidLocationException Se la richiesta fallisce o i dati non sono validi
     */
    public function execute(float $latitude, float $longitude): AddressData
    {
        $apiKey = $this->getApiKey();
        /** @var array<string, mixed> $response */
        $response = $this->makeApiRequest($latitude, $longitude, $apiKey);
        $data = $this->parseResponse($response);

        return $this->mapResponseToAddressData($data);
    }

    /**
     * Get the Bing Maps API key from configuration.
     *
     *
     * @return non-empty-string
     *
     * @throws InvalidLocationException
     */
    private function getApiKey(): string
    {
        /** @var string|null $apiKey */
        $apiKey = config('services.bing.maps_api_key');

        if (empty($apiKey)) {
            throw InvalidLocationException::invalidData('API key di Bing Maps non configurata');
        }

        // We've already checked that $apiKey is not empty
        /* @var non-empty-string $apiKey */
        return $apiKey;
    }

    /**
     * @throws InvalidLocationException
     */
    private function makeApiRequest(float $latitude, float $longitude, string $apiKey): array
    {
        $response = Http::get(self::BASE_URL, [
            'point' => "{$latitude},{$longitude}",
            'key' => $apiKey,
            'includeEntityTypes' => 'Address',
            'maxResults' => 1,
        ]);

        // Handle PromiseInterface|Response union type
        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        /** @var Response $response */
        if (! $response->successful()) {
            throw InvalidLocationException::invalidData('Richiesta a Bing Maps fallita');
        }

        /** @var array<string, mixed> $jsonResponse */
        $jsonResponse = $response->json();

        return $jsonResponse;
    }

    /**
     * @param  array<string, mixed>  $response
     */
    private function parseResponse(array $response): BingMapData
    {
        /** @var array<string, mixed> $location */
        $location = $this->extractLocationFromResponse($response);
        $coordinates = $this->extractCoordinatesFromLocation($location);

        /** @var array<string, mixed> $address */
        $address = $location['address'];

        /** @var array{point: array{coordinates: array{0: float, 1: float}}, address: array{countryRegion: string|null, adminDistrict: string|null, adminDistrict2: string|null, locality: string|null, postalCode: string|null, addressLine: string|null, countryRegionIso2: string|null, neighborhood: string|null}} $validatedLocation */
        $validatedLocation = [
            'point' => [
                'coordinates' => [
                    0 => (float) $coordinates[0],
                    1 => (float) $coordinates[1],
                ],
            ],
            'address' => [
                'countryRegion' => $this->extractStringField($address, 'countryRegion'),
                'adminDistrict' => $this->extractStringField($address, 'adminDistrict'),
                'adminDistrict2' => $this->extractStringField($address, 'adminDistrict2'),
                'locality' => $this->extractStringField($address, 'locality'),
                'postalCode' => $this->extractStringField($address, 'postalCode'),
                'addressLine' => $this->extractStringField($address, 'addressLine'),
                'countryRegionIso2' => $this->extractStringField($address, 'countryRegionIso2'),
                'neighborhood' => $this->extractStringField($address, 'neighborhood'),
            ],
        ];

        return new BingMapData($validatedLocation);
    }

    private function mapResponseToAddressData(BingMapData $data): AddressData
    {
        $res = $data->toArray();

        return new AddressData(
            latitude: (float) ($res['point']['coordinates'][0] ?? 0),
            longitude: (float) ($res['point']['coordinates'][1] ?? 0),
            country: $res['address']['countryRegion'] ?? null,
            city: $res['address']['locality'] ?? null,
            country_code: strtoupper($res['address']['countryRegionIso2'] ?? 'IT'),
            postal_code: (int) ($res['address']['postalCode'] ?? 0),
            locality: $res['address']['locality'] ?? null,
            county: $res['address']['adminDistrict2'] ?? null,
            street: $res['address']['addressLine'] ?? null,
            street_number: $res['address']['houseNumber'] ?? null,
            district: $res['address']['neighborhood'] ?? null,
            state: $res['address']['adminDistrict'] ?? null,
        );
    }

    /**
     * Extract location array from Bing Maps API response.
     *
     * @param  array<string, mixed>  $response
     * @return array<string, mixed>
     *
     * @throws InvalidLocationException
     */
    private function extractLocationFromResponse(array $response): array
    {
        $resourceSets = $response['resourceSets'] ?? [];
        if (! \is_array($resourceSets) || empty($resourceSets) || ! \is_array($resourceSets[0] ?? null)) {
            throw InvalidLocationException::invalidData('Nessun risultato trovato');
        }

        $resources = $resourceSets[0]['resources'] ?? [];
        if (! \is_array($resources) || empty($resources)) {
            throw InvalidLocationException::invalidData('Nessun risultato trovato');
        }

        $location = $resources[0] ?? null;
        if (! \is_array($location) || empty($location)) {
            throw InvalidLocationException::invalidData('Nessun risultato trovato');
        }

        // Validate required structure
        if (! isset($location['point']) || ! \is_array($location['point'])) {
            throw InvalidLocationException::invalidData('Point mancante nella risposta');
        }
        if (! isset($location['point']['coordinates']) || ! \is_array($location['point']['coordinates'])) {
            throw InvalidLocationException::invalidData('Coordinate mancanti nella risposta');
        }
        if (! isset($location['address']) || ! \is_array($location['address'])) {
            throw InvalidLocationException::invalidData('Indirizzo mancante nella risposta');
        }

        /** @var array<string, mixed> $location */
        return $location;
    }

    /**
     * Extract coordinates from location array.
     *
     * @param  array<string, mixed>  $location
     * @return array{0: float, 1: float}
     *
     * @throws InvalidLocationException
     */
    /**
     * @param  array<string, mixed>  $location
     * @return array{0: float, 1: float}
     */
    private function extractCoordinatesFromLocation(array $location): array
    {
        /** @var array<string, mixed> $point */
        $point = $location['point'] ?? [];
        /** @var array<int|string, mixed> $coordinates */
        $coordinates = $point['coordinates'] ?? [];

        if (! isset($coordinates[0], $coordinates[1])) {
            throw InvalidLocationException::invalidData('Coordinate non valide');
        }

        return [
            0 => (float) $coordinates[0],
            1 => (float) $coordinates[1],
        ];
    }

    /**
     * Extract a string field from array with type safety.
     *
     * Centralizes the repeated validation pattern: isset + is_string + default null.
     * This helper reduces cyclomatic complexity by applying DRY principle.
     *
     * @param  array<string, mixed>  $data  Source array
     * @param  string  $key  Field key to extract
     * @return string|null Validated string value or null if not found/not string
     */
    private function extractStringField(array $data, string $key): ?string
    {
        return isset($data[$key]) && \is_string($data[$key]) ? $data[$key] : null;
    }
}
