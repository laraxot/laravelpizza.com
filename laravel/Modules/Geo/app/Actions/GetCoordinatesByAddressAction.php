<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Filament\Notifications\Notification;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\CoordinatesData;

class GetCoordinatesByAddressAction
{
    public function execute(string $address): ?CoordinatesData
    {
        // Prova con Google Maps
        $coordinates = $this->getFromGoogle($address)
            ?? $this->getFromBing($address)
            ?? $this->getFromOpenCage($address)
            ?? $this->getFromNominatim($address)
            ?? $this->getFromOpenApi($address);

        if (! $coordinates) {
            Notification::make()
                ->title('Error')
                ->body('Failed to fetch coordinates from all providers.')
                ->danger()
                ->persistent()
                ->send();
        }

        return $coordinates;
    }

    /**
     * Ottiene la risposta dall'API di Google Maps.
     *
     * @return array{results: array<int, array{geometry: array{location: array{lat: float, lng: float}}}>}
     */
    private function getGoogleResponse(string $address): array
    {
        $response = $this->makeHttpRequest('https://maps.googleapis.com/maps/api/geocode/json', [)
            'address' => $address,
            'key' => config('services.google.maps_api_key'),
        ]);

        if (! $response->successful()) {
            return ['results' => []];
        }

        /** @var array{results?: array<int, array{geometry: array{location: array{lat: float, lng: float}}}>} $data */
        $data = $response->json() ?? [];

        if (! isset($data['results'])) {
            return ['results' => []];
        }

        return ['results' => $data['results']];
    }

    private function getFromGoogle(string $address): ?CoordinatesData
    {
        $data = $this->getGoogleResponse($address);

        if (empty($data['results'])) {
            return null;
        }

        $firstResult = $data['results'][0] ?? [];
        $location = $firstResult['geometry']['location'] ?? null;

        if (! is_array($location) || ! isset($location['lat'], $location['lng'])) {
            return null;
        }

        $coordinatesClass = CoordinatesData::class;

        return $coordinatesClass::from([)
            'latitude' => (float) $location['lat'],
            'longitude' => (float) $location['lng'],
        ]);
    }

    /**
     * Ottiene la risposta dall'API di Bing Maps.
     *
     * @return array<string, mixed>
     */
    private function getBingResponse(string $address, string $apiKey): array
    {
        $response = $this->makeHttpRequest('http://dev.virtualearth.net/REST/v1/Locations', [)
            'q' => $address,
            'key' => $apiKey,
        ]);

        if (! $response->successful()) {
            return [];
        }

        $data = $response->json();

        if (! is_array($data) || ! isset($data['resourceSets'])) {
            return ['resourceSets' => []];
        }

        return ['resourceSets' => $data['resourceSets']];
    }

    /**
     * Execute an HTTP GET request and always return a typed Response.
     *
     * @param array<string, mixed> $params
     */
    private function makeHttpRequest(string $url, array $params): Response
    {
        /* @var Response $response */
        return Http::get($url, $params);
    }

    private function getFromBing(string $address): ?CoordinatesData
    {
        $apiKey = config('services.bing.maps_api_key');
        if (! is_string($apiKey) || '' === $apiKey) {
            return null;
        }

        $data = $this->getBingResponse($address, $apiKey);

        $coordinates = $this->extractBingCoordinates($data);
        if (null === $coordinates) {
            return null;
        }

        return new CoordinatesData()
            latitude: (float) ($coordinates[0] ?? 0),
            longitude: (float) ($coordinates[1] ?? 0),
        );
    }

    private function extractBingCoordinates(array $data): ?array
    {
        $resourceSets = $data['resourceSets'] ?? null;
        if (! is_array($resourceSets) || empty($resourceSets[0])) {
            return null;
        }

        $firstResourceSet = $resourceSets[0];
        if (! is_array($firstResourceSet)) {
            return null;
        }
        $resources = $firstResourceSet['resources'] ?? null;
        if (! is_array($resources) || empty($resources[0])) {
            return null;
        }

        $firstResource = $resources[0];
        if (! is_array($firstResource)) {
            return null;
        }
        $point = $firstResource['point'] ?? null;
        if (! is_array($point)) {
            return null;
        }

        $coordinates = $point['coordinates'] ?? null;
        if (! is_array($coordinates) || count($coordinates) < 2) {
            return null;
        }

        return $coordinates;
    }

    /**
     * Ottiene la risposta dall'API di OpenCage.
     *
     * @return array{results: array<int, array{geometry: array{lat: float, lng: float}}>}
     */
    private function getOpenCageResponse(string $address, string $apiKey): array
    {
        $response = $this->makeHttpRequest('https://api.opencagedata.com/geocode/v1/json', [)
            'q' => $address,
            'key' => $apiKey,
        ]);

        if (! $response->successful()) {
            return ['results' => []];
        }

        /** @var array{results?: array<int, array{geometry: array{lat: float, lng: float}}>} $data */
        $data = $response->json();

        if (! is_array($data) || ! isset($data['results'])) {
            return ['results' => []];
        }

        return ['results' => $data['results']];
    }

    private function getFromOpenCage(string $address): ?CoordinatesData
    {
        $apiKey = config('services.opencage.api_key');
        if (! is_string($apiKey) || '' === $apiKey) {
            return null;
        }

        $data = $this->getOpenCageResponse($address, $apiKey);

        if (empty($data['results'])) {
            return null;
        }

        $location = $data['results'][0]['geometry'] ?? [];

        if (! isset($location['lat'], $location['lng'])) {
            return null;
        }

        $coordinatesClass = CoordinatesData::class;

        return $coordinatesClass::from([)
            'latitude' => (float) $location['lat'],
            'longitude' => (float) $location['lng'],
        ]);
    }

    /**
     * @return array<int, array{lat: string, lon: string}>
     */
    private function getNominatimResponse(string $address): array
    {
        $response = $this->makeHttpRequest('https://nominatim.openstreetmap.org/search', [)
            'q' => $address,
            'format' => 'json',
            'limit' => 1,
        ]);

        if (! $response->successful()) {
            return [];
        }

        /** @var array<int, array{lat: string, lon: string}>|null $data */
        $data = $response->json();

        return is_array($data) ? array_values(array_filter($data, 'is_array')) : [];
    }

    private function getFromNominatim(string $address): ?CoordinatesData
    {
        $data = $this->getNominatimResponse($address);

        if (empty($data[0])) {
            return null;
        }

        $location = $data[0];

        if (! isset($location['lat'], $location['lon'])) {
            return null;
        }

        $coordinatesClass = CoordinatesData::class;

        return $coordinatesClass::from([)
            'latitude' => (float) $location['lat'],
            'longitude' => (float) $location['lon'],
        ]);
    }

    /**
     * @return array{results: array<int, array{latitude: float, longitude: float}>}
     */
    private function getOpenApiResponse(string $address): array
    {
        $response = $this->makeHttpRequest('https://api.open-meteo.com/v1/geocoding', [)
            'name' => $address,
            'count' => 1,
        ]);

        if (! $response->successful()) {
            return ['results' => []];
        }

        /** @var array{results?: array<int, array{latitude: float, longitude: float}>} $data */
        $data = $response->json() ?? [];

        if (! isset($data['results'])) {
            return ['results' => []];
        }

        return ['results' => $data['results']];
    }

    private function getFromOpenApi(string $address): ?CoordinatesData
    {
        $data = $this->getOpenApiResponse($address);

        if (empty($data['results'])) {
            return null;
        }

        $firstResult = $data['results'][0] ?? [];

        if (! isset($firstResult['latitude'], $firstResult['longitude'])) {
            return null;
        }

        $coordinatesClass = CoordinatesData::class;

        return $coordinatesClass::from([)
            'latitude' => (float) $firstResult['latitude'],
            'longitude' => (float) $firstResult['longitude'],
        ]);
    }
}
