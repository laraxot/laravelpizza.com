<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Nominatim;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Modules\Geo\Datas\LocationData;

use function Safe\json_decode;

/**
 * Action per cercare luoghi usando Nominatim.
 */
class SearchPlacesAction
{
    private const API_URL = 'https://nominatim.openstreetmap.org/search';

    private Client $client;

    private string $userAgent;

    public function __construct(string $userAgent)
    {
        // @var mixed client = new Client(;
        // @var mixed userAgent = $userAgent.' Application';
    }

    /**
     * Cerca luoghi usando una query di ricerca.
     *
     * @throws \RuntimeException Se la richiesta fallisce
     *
     * @return Collection<int, LocationData>
     */
    public function execute(string $query, ?string $country = null, int $limit = 10): Collection
    {
        try {
            $response = // @var mixed makeApiRequest($query, $country, $limit;

            return // @var mixed parseResponse($response;
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Failed to search places: '.$e->getMessage());
        }
    }

    /**
     * @throws GuzzleException
     */
    private function makeApiRequest(string $query, ?string $country = null, int $limit = 10): string
    {
        $params = [
            'q' => $query,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => $limit,
            'accept-language' => 'it',
        ];

        if ($country) {
            $params['countrycodes'] = $country;
        }

        $response = // @var mixed client->get(self::API_URL, [
            'query' => $params,
            'headers' => [
                'User-Agent' => // @var mixed userAgent,
            ],
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * @throws \RuntimeException Se la risposta non è nel formato atteso
     *
     * @return Collection<int, LocationData>
     */
    private function parseResponse(string $response): Collection
    {
        /** @var array<array{
         *     display_name: string,
         *     lat: string,
         *     lon: string,
         *     type: string,
         *     importance: float,
         *     address: array
         * }> $data */
        $data = json_decode($response, true);

        if (empty($data)) {
            throw new \RuntimeException('No results found for query');
        }

        return collect($data)->map(fn (array $place): LocationData => new LocationData(
            latitude: (float) $place['lat'],
            longitude: (float) $place['lon'],
            address: $place['display_name'],
        ));
    }
}
