<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Datas\Routing\TravelTimeData;
use Modules\Geo\Infrastructure\Config\GeoApiEndpoints;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_decode;

/**
 * Action per calcolare il tempo di percorrenza tra due punti tramite Google Maps.
 *
 * Questa classe utilizza l'API Google Maps Distance Matrix per calcolare
 * il tempo di percorrenza tra due località, considerando il traffico attuale.
 */
class CalculateTravelTimeAction
{
    use QueueableAction;

    private const string API_URL = GeoApiEndpoints::GOOGLE_DISTANCE_MATRIX;

    public function __construct(
        private readonly Client $client,
    ) {}

    /**
     * Calcola il tempo di percorrenza tra due punti.
     *
     * @throws \InvalidArgumentException Se i dati di input non sono validi
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
     * @throws \InvalidArgumentException Se i dati di input non sono validi
     * @throws \RuntimeException Se la chiave API non è configurata o i dati non sono validi
     */
    private function validateInput(LocationData $origin, LocationData $destination): void
    {
        $apiKey = config('services.google.maps_api_key');
        if (! \is_string($apiKey) || '' === $apiKey) {
            throw new \RuntimeException('Google Maps API key not configured');
        }
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
        $data = json_decode($response, true);

<<<<<<< .merge_file_j6dVdl
        if (! \is_array($data) || ! \is_string($data['status'] ?? null)) {
            return TravelTimeData::error('INVALID_RESPONSE');
        }

        /** @var string $status */
        $status = $data['status'];
        if ('OK' !== $status) {
            return TravelTimeData::error($status);
        }

=======
<<<<<<< .merge_file_6f9sEl
        if ($data['status'] !== 'OK') {
            return TravelTimeData::error($data['status']);
        }

        $element = $data['rows'][0]['elements'][0];
        if (! $element || $element['status'] !== 'OK') {
=======
        if (! \is_array($data) || ! \is_string($data['status'] ?? null)) {
            return TravelTimeData::error('INVALID_RESPONSE');
        }

        /** @var string $status */
        $status = $data['status'];
        if ('OK' !== $status) {
            return TravelTimeData::error($status);
        }

>>>>>>> .merge_file_AJUf8V
        $rows = $data['rows'] ?? null;
        $firstRow = \is_array($rows) ? ($rows[0] ?? null) : null;
        $elements = \is_array($firstRow) ? ($firstRow['elements'] ?? null) : null;
        $element = \is_array($elements) ? ($elements[0] ?? null) : null;

        if (! \is_array($element) || ! \is_string($element['status'] ?? null)) {
            return TravelTimeData::error('INVALID_RESPONSE');
        }

        if ('OK' !== $element['status']) {
<<<<<<< .merge_file_j6dVdl
=======
>>>>>>> .merge_file_7pIkDx
>>>>>>> .merge_file_AJUf8V
            return TravelTimeData::error($element['status']);
        }

        /** @var array{
         *     duration: array{value: int, text: string},
         *     duration_in_traffic?: array{value: int, text: string},
         *     distance: array{value: int, text: string},
         *     status: string
         * } $element */
        return new TravelTimeData(
            duration_seconds: (int) $element['duration']['value'],
            duration_in_traffic_seconds: (int) ($element['duration_in_traffic']['value'] ?? $element['duration']['value']),
            distance_meters: (int) $element['distance']['value'],
            formatted_duration: (string) $element['duration']['text'],
            formatted_distance: (string) $element['distance']['text'],
            status: $status,
        );
    }
}
