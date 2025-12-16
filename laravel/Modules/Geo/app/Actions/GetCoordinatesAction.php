<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Datas\LocationData;

use function Safe\json_decode;

/**
 * Action per ottenere le coordinate geografiche da un indirizzo usando Google Maps Geocoding API.
 */
class GetCoordinatesAction
{
    /**
     * Ottiene le coordinate geografiche da un indirizzo.
     *
     * @throws \RuntimeException Se la richiesta fallisce o la risposta non è valida
     */
    public function execute(string $formattedAddress): ?LocationData
    {
        $apiKey = config('services.google.maps.key');
        if (! $apiKey) {
            throw new \RuntimeException('Google Maps API key not found');
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $formattedAddress,
            'key' => $apiKey,
        ]);

        // Handle PromiseInterface|Response union type
        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        /** @var Response $response */
        if (! $response->successful()) {
            throw new \RuntimeException('Failed to get coordinates from Google Maps API');
        }

        /** @var array{status: string, results: array<int, array{geometry: array{location: array{lat: float, lng: float}}}>} $data */
        $data = json_decode($response->body(), true);

        if ('OK' !== $data['status'] || empty($data['results'])) {
            return null;
        }

        $location = $data['results'][0]['geometry']['location'];

        return new LocationData(
            latitude: (float) $location['lat'],
            longitude: (float) $location['lng'],
            address: $formattedAddress,
        );
    }
}
