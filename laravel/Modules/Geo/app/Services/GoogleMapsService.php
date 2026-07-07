<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
use Spatie\QueueableAction\QueueableAction;

/**
 * Servizio per le interazioni con l'API di Google Maps.
 */
class GoogleMapsService
{
    use QueueableAction;

    private const GEOCODING_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    private const DISTANCE_MATRIX_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    private const ELEVATION_URL = 'https://maps.googleapis.com/maps/api/elevation/json';

    /**
     * Ottiene la chiave API dal file di configurazione.
     *
     * @throws \RuntimeException Se la chiave API non è configurata
     */
    private function getApiKey(): string
    {
        /** @var string|null $apiKey */
        $apiKey = config("geo.api_keys.{$this->getServiceName()}");

        if (empty($apiKey)) {
            throw new \RuntimeException("API key non configurata per {$this->getServiceName()}");
        }

        return $apiKey;
    }

    /**
     * Esegue una richiesta HTTP con rate limiting, cache e retry.
     *
     * @param string               $method   Metodo HTTP (GET, POST, etc.)
     * @param string               $url      URL della richiesta
     * @param array<string, mixed> $params   Parametri della richiesta
     * @param bool                 $useCache Se utilizzare la cache
     *
     * @throws \RuntimeException Se la richiesta fallisce
     *
     * @return array<string, mixed>
     */
    private function makeRequest(string $method, string $url, array $params = [], bool $useCache = true): array
    {
        $cacheKey = $this->getCacheKey($method, $url, $params);

        if ($useCache && config('geo.cache.enabled')) {
            /** @var array<string, mixed>|null $cached */
            $cached = Cache::get($cacheKey);
            if (null !== $cached) {
                return $cached;
            }
        }

        // Rate limiting
        /** @var int $maxAttempts */
        $maxAttempts = config("geo.rate_limits.{$this->getServiceName()}.requests_per_second", 50);
        RateLimiter::attempt($this->getServiceName(), $maxAttempts, fn () => true);

        try {
            $client = $this->buildHttpClient();
            $methodLower = strtolower($method);

            /** @var Response $response */
            $response = $client->{$methodLower}($url, $params);

            if (! $response->successful()) {
                throw new \RuntimeException("Richiesta fallita a {$this->getServiceName()}: ".(string) $response->status());
            }

            $data = $response->json();

            // Validazione tipo di ritorno per PHPStan level 9 compliance
            if (! is_array($data)) {
                throw new \RuntimeException('Risposta API non valida: atteso array, ricevuto '.gettype($data));
            }

            // Assicura che sia array<string, mixed> come richiesto dalla signature
            /** @var array<string, mixed> $validatedData */
            $validatedData = $data;

            if ($useCache && config('geo.cache.enabled')) {
                /** @var int $ttl */
                $ttl = config('geo.cache.ttl', 86400);
                Cache::put($cacheKey, $validatedData, $ttl);
            }

            return $validatedData;
        } catch (\Throwable $e) {
            throw new \RuntimeException("Errore durante la richiesta a {$this->getServiceName()}: ".$e->getMessage(), 0, $e);
        }
    }

    /**
     * Costruisce il client HTTP con timeout e retry configurati.
     */
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
     * Genera una chiave di cache per la richiesta.
     *
     * @param string               $method Metodo HTTP
     * @param string               $url    URL della richiesta
     * @param array<string, mixed> $params Parametri della richiesta
     */
    private function getCacheKey(string $method, string $url, array $params): string
    {
        /** @var string $prefix */
        $prefix = config('geo.cache.prefix', 'geo_');
        $hash = md5($method.$url.serialize($params));

        return "{$prefix}{$this->getServiceName()}_{$hash}";
    }

    /**
     * Esegue una richiesta di geocodifica inversa.
     *
     * @throws GoogleMapsApiException Se la richiesta fallisce
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
     * Calcola la matrice delle distanze.
     *
     * @param array<string> $origins      Punti di origine (formato: "lat,lng|lat,lng|...")
     * @param array<string> $destinations Punti di destinazione (formato: "lat,lng|lat,lng|...")
     *
     * @throws GoogleMapsApiException Se la richiesta fallisce
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
     * Ottiene l'elevazione per un punto.
     *
     * @throws GoogleMapsApiException Se la richiesta fallisce
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

    public function execute(): void
    {
    }
}
