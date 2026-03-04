<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\TravelTimeData;
use Webmozart\Assert\Assert;

use function Safe\json_decode;

/**
 * Action per calcolare il tempo di percorrenza tra due punti tramite Google Maps.
 *
 * Questa classe utilizza l'API Google Maps Distance Matrix per calcolare
 * il tempo di percorrenza tra due località, considerando il traffico attuale.
 */
readonly class CalculateTravelTimeAction
{
    private const API_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    public function __construct(
        private Client $client,
    ) {}

    /**
     * Calcola il tempo di percorrenza tra due punti.
     *
     * @throws \RuntimeException Se la chiave API non è configurata o la richiesta fallisce
     */
    public function execute(LocationData $origin, LocationData $destination): TravelTimeData
    {
        $this->validateInput($origin, $destination);

        try {
            $response = $this->makeApiRequest($origin, $destination);

            return $this->parseResponse($response);
        } catch (GuzzleException $e) {
            Log::error('Google Maps Distance Matrix API request failed', [
                'error' => $e->getMessage(),
                'origin' => $origin,
                'destination' => $destination,
            ]);

            return TravelTimeData::error('REQUEST_FAILED');
        }
    }

    /**
     * Valida i dati di input.
     *
     * @throws \RuntimeException Se la chiave API non è configurata o i dati non sono validi
     */
    private function validateInput(LocationData $origin, LocationData $destination): void
    {
        $apiKey = config('services.google.maps_api_key');
        Assert::notEmpty($apiKey, 'Google Maps API key not configured');
        Assert::notSame(
            [$origin->latitude, $origin->longitude],
            [$destination->latitude, $destination->longitude],
            'Origin and destination cannot be the same location',
        );
    }

    /**
     * Effettua la richiesta all'API di Google Maps.
     *
     * @throws GuzzleException Se la richiesta fallisce
     */
    private function makeApiRequest(LocationData $origin, LocationData $destination): string
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'origins' => sprintf('%F,%F', $origin->latitude, $origin->longitude),
                'destinations' => sprintf('%F,%F', $destination->latitude, $destination->longitude),
                'mode' => 'driving',
                'departure_time' => 'now',
                'traffic_model' => 'best_guess',
                'key' => config('services.google.maps_api_key'),
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Elabora la risposta dell'API.
     *
     * @throws \RuntimeException Se la risposta non è valida
     */
    private function parseResponse(string $response): TravelTimeData
    {
        /** @var array{
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
         * } $data */
        $data = json_decode($response, true);

        if (($data['status'] ?? null) !== 'OK') {
            return TravelTimeData::error($data['status'] ?? 'INVALID_RESPONSE');
        }

        $element = $data['rows'][0]['elements'][0] ?? null;
        if (! $element || ($element['status'] ?? null) !== 'OK') {
            return TravelTimeData::error($element['status'] ?? 'NO_ROUTE');
        }

        return new TravelTimeData(
            duration_seconds: (int) ($element['duration']['value'] ?? 0),
            duration_in_traffic_seconds: (int) ($element['duration_in_traffic']['value'] ?? $element['duration']['value'] ?? 0),
            distance_meters: (int) ($element['distance']['value'] ?? 0),
            formatted_duration: (string) ($element['duration']['text'] ?? ''),
            formatted_distance: (string) ($element['distance']['text'] ?? ''),
            status: (string) ($data['status'] ?? 'ERROR'),
        );
    }
}
