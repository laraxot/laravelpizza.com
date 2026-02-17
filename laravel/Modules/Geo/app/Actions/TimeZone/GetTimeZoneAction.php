<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\TimeZone;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Modules\Geo\Datas\TimeZoneData;

use function Safe\json_decode;

/**
 * Action per ottenere il fuso orario da coordinate geografiche.
 */
class GetTimeZoneAction
{
    private const API_URL = 'https://maps.googleapis.com/maps/api/timezone/json';

    private Client $client;

    private ?string $apiKey;

    public function __construct(?string $apiKey = null)
    {
        $this->client = new Client;
        $this->apiKey = $apiKey;
    }

    /**
     * @throws GuzzleException
     */
    public function execute(float $latitude, float $longitude): TimeZoneData
    {
        $response = $this->client->get(self::API_URL, [
            'query' => [
                'location' => $latitude.','.$longitude,
                'timestamp' => time(),
                'key' => $this->apiKey,
            ],
        ]);

        /** @var array{status: string, timeZoneId: string, timeZoneName: string, rawOffset: int, dstOffset: int, countryCode?: string} $data */
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] !== 'OK') {
            throw new \RuntimeException('Failed to get timezone: '.($data['errorMessage'] ?? $data['status']));
        }

        return new TimeZoneData(
            timeZoneId: $data['timeZoneId'],
            timeZoneName: $data['timeZoneName'],
            rawOffset: $data['rawOffset'],
            dstOffset: $data['dstOffset'],
            countryCode: $data['countryCode'] ?? '',
        );
    }
}
