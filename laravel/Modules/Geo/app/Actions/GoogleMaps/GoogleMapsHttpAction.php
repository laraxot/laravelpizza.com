<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GoogleMaps;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
use Modules\Geo\Infrastructure\Config\GeoApiEndpoints;
use Spatie\QueueableAction\QueueableAction;

/**
 * Client HTTP Google Maps (geocoding, distance matrix, elevation).
 *
 * Sostituisce GoogleMapsService + BaseGeoService.
 * Usa FetchGoogleMapsElevationAction / GetAddressFromGoogleMapsAction / GoogleMapsHttpAction.
 */
class GoogleMapsHttpAction
{
    use QueueableAction;

    private const string GEOCODING_URL = GeoApiEndpoints::GOOGLE_GEOCODING;

    private const string DISTANCE_MATRIX_URL = GeoApiEndpoints::GOOGLE_DISTANCE_MATRIX;

    private const string ELEVATION_URL = GeoApiEndpoints::GOOGLE_ELEVATION;

    /**
     * @return array<string, mixed>
     *
     * @throws GoogleMapsApiException
     */
    public function executeReverseGeocode(float $latitude, float $longitude): array
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
     * @param  array<string>  $origins
     * @param  array<string>  $destinations
     * @return array<string, mixed>
     *
     * @throws GoogleMapsApiException
     */
    public function executeDistanceMatrix(array $origins, array $destinations): array
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
     * @return array<string, mixed>
     *
     * @throws GoogleMapsApiException
     */
    public function executeElevation(float $latitude, float $longitude): array
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

    private function getApiKey(): string
    {
        /** @var string|null $apiKey */
        $apiKey = config('geo.api_keys.google_maps');

        if (empty($apiKey)) {
            throw new \RuntimeException('API key non configurata per google_maps');
        }

        return $apiKey;
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    private function makeRequest(string $method, string $url, array $params = [], bool $useCache = true): array
    {
        $cacheKey = $this->getCacheKey($method, $url, $params);

        if ($useCache && config('geo.cache.enabled')) {
            /** @var array<string, mixed>|null $cached */
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        /** @var int $maxAttempts */
        $maxAttempts = config('geo.rate_limits.google_maps.requests_per_second', 50);
        RateLimiter::attempt('google_maps', $maxAttempts, fn (): bool => true);

        $client = $this->buildHttpClient();
        $methodLower = strtolower($method);

        /** @var Response $response */
        $response = $client->{$methodLower}($url, $params);

        if (! $response->successful()) {
            throw new \RuntimeException('Richiesta fallita a google_maps: '.(string) $response->status());
        }

        $data = $response->json();
        if (! is_array($data)) {
            throw new \RuntimeException('Risposta API non valida: atteso array, ricevuto '.gettype($data));
        }

        /** @var array<string, mixed> $validatedData */
        $validatedData = $data;

        if ($useCache && config('geo.cache.enabled')) {
            /** @var int $ttl */
            $ttl = config('geo.cache.ttl', 86400);
            Cache::put($cacheKey, $validatedData, $ttl);
        }

        return $validatedData;
    }

    private function buildHttpClient(): PendingRequest
    {
        /** @var float $timeout */
        $timeout = config('geo.http_client.timeout', 5.0);
        /** @var int $retryTimes */
        $retryTimes = config('geo.http_client.retry.times', 3);
        /** @var int $retrySleep */
        $retrySleep = config('geo.http_client.retry.sleep', 100);
        /** @var array<string> $whenTypes */
        $whenTypes = config('geo.http_client.retry.when', []);

        return Http::timeout($timeout)->retry($retryTimes, $retrySleep, function (\Throwable $exception) use ($whenTypes): bool {
            foreach ($whenTypes as $type) {
                if (is_a($exception, "\\GuzzleHttp\\Exception\\{$type}")) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private function getCacheKey(string $method, string $url, array $params): string
    {
        /** @var string $prefix */
        $prefix = config('geo.cache.prefix', 'geo_');
        $hash = md5($method.$url.serialize($params));

        return "{$prefix}google_maps_{$hash}";
    }
}
