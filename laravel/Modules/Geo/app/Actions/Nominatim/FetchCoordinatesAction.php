<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Modules\Geo\Datas\LocationData;

use function Safe\json_decode;

/**
 * Action per ottenere le coordinate geografiche da un indirizzo usando Nominatim.
 */
class FetchCoordinatesAction
{
    private const API_URL = 'https://nominatim.openstreetmap.org/search';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Ottiene le coordinate geografiche da un indirizzo.
     *
     * @param  string  $address  Indirizzo da geocodificare
     *
     * @throws GuzzleException
     * @throws \RuntimeException
     */
    public function execute(string $address): LocationData
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
            ],
            'headers' => [
                'User-Agent' => 'Xot/1.0',
            ],
        ]);

        /** @var array<int, array{lat: string, lon: string, display_name: string}> $data */
        $data = json_decode($response->getBody()->getContents(), true);

        if (empty($data)) {
            throw new \RuntimeException('No results found for address: '.$address);
        }

        $result = $data[0];

        return new LocationData(
            latitude: (float) $result['lat'],
            longitude: (float) $result['lon'],
            address: $result['display_name'],
        );
    }
}
