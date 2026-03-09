<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Modules\Geo\Datas\LocationData;

use function Safe\json_decode;

/**
 * Action per cercare un luogo usando Nominatim.
 */
class LookupPlaceAction
{
    private const API_URL = 'https://nominatim.openstreetmap.org/lookup';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Cerca un luogo usando il suo OSM ID.
     *
     * @param string $osmId ID OpenStreetMap del luogo
     *
     * @throws GuzzleException
     * @throws \RuntimeException
     */
    public function execute(string $osmId): LocationData
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'osm_ids' => $osmId,
                'format' => 'json',
            ],
            'headers' => [
                'User-Agent' => 'Xot/1.0',
            ],
        ]);

        /** @var array<int, array{lat: string, lon: string, display_name: string}> $data */
        $data = json_decode($response->getBody()->getContents(), true);

        if (empty($data)) {
            throw new \RuntimeException('No results found for OSM ID: '.$osmId);
        }

        $result = $data[0];

        return new LocationData(
            latitude: (float) $result['lat'],
            longitude: (float) $result['lon'],
            address: $result['display_name'],
        );
    }
}
