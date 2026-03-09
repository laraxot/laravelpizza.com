<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Modules\Geo\Datas\LocationData;

use function Safe\json_decode;

/**
 * Action per ottenere l'indirizzo da coordinate geografiche usando Nominatim.
 */
class ReverseGeocodeAction
{
    private const API_URL = 'https://nominatim.openstreetmap.org/reverse';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Ottiene l'indirizzo da coordinate geografiche.
     *
     * @param float $latitude  Latitudine
     * @param float $longitude Longitudine
     *
     * @throws GuzzleException
     * @throws \RuntimeException
     */
    public function execute(float $latitude, float $longitude): LocationData
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
            ],
            'headers' => [
                'User-Agent' => 'Xot/1.0',
            ],
        ]);

        /** @var array{lat: string, lon: string, display_name: string} $data */
        $data = json_decode($response->getBody()->getContents(), true);

        return new LocationData(
            latitude: $latitude,
            longitude: $longitude,
            address: $data['display_name'],
        );
    }
}
