<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\IPGeolocation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Modules\Geo\Datas\IPLocationData;

use function Safe\json_decode;

/**
 * Action per ottenere informazioni di geolocalizzazione da un indirizzo IP.
 */
class FetchIPLocationAction
{
    private const API_URL = 'http://ip-api.com/json/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Ottiene le informazioni di geolocalizzazione per un indirizzo IP.
     *
     * @param  string  $ip  Indirizzo IP da geolocalizzare
     *
     * @throws GuzzleException
     * @throws \RuntimeException
     */
    public function execute(string $ip): IPLocationData
    {
        $response = $this->client->get(self::API_URL.$ip, [
            'query' => [
                'fields' => implode(',', [
                    'status',
                    'message',
                    'country',
                    'countryCode',
                    'region',
                    'regionName',
                    'city',
                    'lat',
                    'lon',
                    'timezone',
                    'isp',
                ]),
            ],
        ]);

        /** @var array{
         *     status: string,
         *     message?: string,
         *     country?: string,
         *     countryCode?: string,
         *     region?: string,
         *     regionName?: string,
         *     city?: string,
         *     lat?: float,
         *     lon?: float,
         *     timezone?: string,
         *     isp?: string
         * } $data
         */
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] !== 'success') {
            throw new \RuntimeException('Failed to get IP location: '.($data['message'] ?? 'Unknown error'));
        }

        return new IPLocationData(
            ip: $ip,
            city: $data['city'] ?? null,
            region: $data['regionName'] ?? null,
            country: $data['countryCode'] ?? null,
            countryName: $data['country'] ?? null,
            latitude: $data['lat'] ?? null,
            longitude: $data['lon'] ?? null,
            timezone: $data['timezone'] ?? null,
            isp: $data['isp'] ?? null,
        );
    }
}
