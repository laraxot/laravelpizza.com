<?php

declare(strict_types=1);

namespace Modules\Geo\Adapters;

use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
use Modules\Geo\Infrastructure\Config\GeoApiEndpoints;

/**
 * Adapter per le interazioni con l'API di Google Maps (geocoding, distance matrix, elevation).
 */
class GoogleMapsClient extends GeoHttpClientBase
{
    private const string GEOCODING_URL = GeoApiEndpoints::GOOGLE_GEOCODING;

    private const string DISTANCE_MATRIX_URL = GeoApiEndpoints::GOOGLE_DISTANCE_MATRIX;

    private const string ELEVATION_URL = GeoApiEndpoints::GOOGLE_ELEVATION;

    /**
     * @throws GoogleMapsApiException
     *
     * @return array<string, mixed>
     */
    public function reverseGeocode(float $latitude, float $longitude): array
    {
        try {
            return $this->makeRequest('GET', self::GEOCODING_URL, [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $this->getApiKey(),
                'language' => 'it',
            ]);
        } catch (\Throwable $e) {
            throw GoogleMapsApiException::requestFailed($e->getMessage());
        }
    }

    /**
     * @param array<string> $origins
     * @param array<string> $destinations
     *
     * @throws GoogleMapsApiException
     *
     * @return array<string, mixed>
     */
    public function getDistanceMatrix(array $origins, array $destinations): array
    {
        try {
            return $this->makeRequest('GET', self::DISTANCE_MATRIX_URL, [
                'origins' => implode('|', $origins),
                'destinations' => implode('|', $destinations),
                'key' => $this->getApiKey(),
                'language' => 'it',
                'units' => 'metric',
            ]);
        } catch (\Throwable $e) {
            throw GoogleMapsApiException::requestFailed($e->getMessage());
        }
    }

    /**
     * @throws GoogleMapsApiException
     *
     * @return array<string, mixed>
     */
    public function getElevation(float $latitude, float $longitude): array
    {
        try {
            return $this->makeRequest('GET', self::ELEVATION_URL, [
                'locations' => "{$latitude},{$longitude}",
                'key' => $this->getApiKey(),
            ]);
        } catch (\Throwable $e) {
            throw GoogleMapsApiException::requestFailed($e->getMessage());
        }
    }

    protected function getServiceName(): string
    {
        return 'google_maps';
    }
}
