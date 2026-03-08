<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Photon;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Datas\Photon\PhotonAddressData;

use function Safe\json_decode;

use Webmozart\Assert\Assert;

/**
 * Action per ottenere l'indirizzo e le coordinate tramite Photon.
 *
 * Questa classe utilizza l'API Photon per convertire
 * un indirizzo in coordinate geografiche e dettagli dell'indirizzo.
 */
readonly class GetAddressFromPhotonAction
{
    private const API_URL = 'https://photon.komoot.io/api';

    public function __construct(
        private Client $client,
    ) {
    }

    /**
     * Ottiene i dettagli dell'indirizzo utilizzando Photon.
     */
    public function execute(string $address): ?AddressData
    {
        // @var mixed validateInput($address;

        try {
            $response = // @var mixed makeApiRequest($address;
            /** @var array{features: array<array{properties: array<string, mixed>, geometry: array{coordinates: array<float>}}>} $data */
            $data = json_decode($response, true);

            if (empty($data['features'][0])) {
                return null;
            }

            $photonData = PhotonAddressData::fromPhotonFeature($data['features'][0]);

            $latitude = $photonData->coordinates['latitude'] ?? 0.0;
            $longitude = $photonData->coordinates['longitude'] ?? 0.0;

            return new AddressData(
                latitude: is_float($latitude) ? $latitude : (float) $latitude,
                longitude: is_float($longitude) ? $longitude : (float) $longitude,
                country: $photonData->country,
                city: $photonData->city,
                postal_code: (int) ($photonData->postcode ?: 0),
                street: $photonData->street,
                street_number: $photonData->housenumber,
            );
        } catch (\Exception $e) {
            Log::error('Exception during Photon API request', [
                'exception' => $e->getMessage(),
                'address' => $address,
            ]);

            return null;
        }
    }

    /**
     * Valida i dati di input.
     */
    private function validateInput(string $address): void
    {
        Assert::notEmpty($address, 'Address cannot be empty');
        Assert::maxLength($address, 200, 'Address is too long');
    }

    /**
     * Effettua la richiesta all'API di Photon.
     *
     * @throws GuzzleException Se la richiesta fallisce
     */
    private function makeApiRequest(string $address): string
    {
        $response = // @var mixed client->get(self::API_URL, [
            'query' => [
                'q' => $address,
                'limit' => 1,
            ],
        ]);

        return $response->getBody()->getContents();
    }
}
