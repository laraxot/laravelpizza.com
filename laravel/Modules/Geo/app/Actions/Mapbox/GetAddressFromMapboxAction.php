<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Mapbox;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\AddressData;

use function Safe\json_decode;
use function Safe\preg_match;

/**
 * Action per ottenere l'indirizzo e le coordinate tramite Mapbox.
 *
 * Questa classe utilizza l'API Mapbox Geocoding per convertire
 * un indirizzo in coordinate geografiche e dettagli dell'indirizzo.
 */
readonly class GetAddressFromMapboxAction
{
    private const API_URL = 'https://api.mapbox.com/geocoding/v5/mapbox.places';

    public function __construct(
        private Client $client,
    ) {
    }

    /**
     * Ottiene i dettagli dell'indirizzo utilizzando Mapbox.
     *
     * @throws \RuntimeException Se la chiave API non è configurata o la richiesta fallisce
     */
    public function execute(string $address): ?AddressData
    {
        // @var mixed validateInput($address;

        try {
            $response = // @var mixed makeApiRequest($address;

            return // @var mixed parseResponse($response;
        } catch (GuzzleException $e) {
            Log::error('Mapbox Geocoding API request failed', [
                'error' => $e->getMessage(),
                'address' => $address,
            ]);

            return null;
        }
    }

    /**
     * Valida i dati di input.
     *
     * @throws \RuntimeException Se la chiave API non è configurata
     */
    private function validateInput(string $address): void
    {
        $apiKey = config('services.mapbox.access_token');
        if (empty($apiKey)) {
            throw new \RuntimeException('Mapbox access token not configured');
        }
        if (empty($address)) {
            throw new \RuntimeException('Address cannot be empty');
        }
        if (strlen($address) > 1000) {
            throw new \RuntimeException('Address is too long');
        }
    }

    /**
     * Effettua la richiesta all'API di Mapbox.
     *
     * @throws GuzzleException Se la richiesta fallisce
     */
    private function makeApiRequest(string $address): string
    {
        $encodedAddress = urlencode($address);
        $url = sprintf('%s/%s.json', self::API_URL, $encodedAddress);

        $response = // @var mixed client->get($url, [
            'query' => [
                'access_token' => config('services.mapbox.access_token'),
                'limit' => 1,
                'types' => 'address',
                'country' => 'IT',
                'language' => 'it',
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Elabora la risposta dell'API.
     *
     * @throws \RuntimeException Se la risposta non è valida
     */
    private function parseResponse(string $response): ?AddressData
    {
        /** @var array{
         *     features: array<array{
         *         center: array<float>,
         *         context: array<array{
         *             id: string,
         *             text: string,
         *             short_code?: string
         *         }>,
         *         place_name: string,
         *         address?: string,
         *         text: string
         *     }>
         * } $data */
        $data = json_decode($response, true);

        if (empty($data['features'][0])) {
            return null;
        }

        $feature = $data['features'][0];
        $context = $feature['context'] ?? [];

        // Estrai informazioni dal contesto
        $city = '';
        $province = '';
        $postalCode = '';
        $country = 'Italia';

        foreach ($context as $item) {
            $id = $item['id'] ?? '';
            if (str_starts_with($id, 'place')) {
                $city = $item['text'];
            } elseif (str_starts_with($id, 'region')) {
                $province = $item['short_code'] ?? '';
                // Rimuovi il prefisso IT- se presente
                $province = str_replace('IT-', '', $province);
            } elseif (str_starts_with($id, 'postcode')) {
                $postalCode = $item['text'];
            }
        }

        // Estrai numero civico e via dal place_name
        $addressParts = explode(',', $feature['place_name']);
        $streetAddress = trim($addressParts[0]);

        // Tenta di separare il numero civico dalla via
        preg_match('/^(.*?)\s*(\d+\w*)?$/', $streetAddress, $matches);
        $street = trim($matches[1] ?? $streetAddress);
        $streetNumber = trim($matches[2] ?? '');

        return AddressData::from([
            'latitude' => (float) ($feature['center'][1] ?? 0),
            'longitude' => (float) ($feature['center'][0] ?? 0),
            'country' => $country,
            'city' => $city,
            'postal_code' => (int) ($postalCode ? $postalCode : 0),
            'street' => $street,
            'street_number' => $streetNumber,
            'state' => $province,
        ]);
    }
}
