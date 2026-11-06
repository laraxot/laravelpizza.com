<?php

declare(strict_types=1);

namespace Modules\Geo\Adapters;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Shared HTTP adapter mechanics (rate limiting, cache, retry) for geo API clients.
 */
abstract class GeoHttpClientBase
{
    abstract protected function getServiceName(): string;

    /**
     * @throws \RuntimeException
     */
    protected function getApiKey(): string
    {
        /** @var string|null $apiKey */
        $apiKey = config("geo.api_keys.{$this->getServiceName()}");

        if (empty($apiKey)) {
            throw new \RuntimeException("API key non configurata per {$this->getServiceName()}");
        }

        return $apiKey;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @throws \RuntimeException
     *
     * @return array<string, mixed>
     */
    protected function makeRequest(string $method, string $url, array $params = [], bool $useCache = true): array
    {
        $cacheKey = $this->getCacheKey($method, $url, $params);

        if ($useCache && config('geo.cache.enabled')) {
            /** @var array<string, mixed>|null $cached */
            $cached = Cache::get($cacheKey);
            if (null !== $cached) {
                return $cached;
            }
        }

        /** @var int $maxAttempts */
        $maxAttempts = config("geo.rate_limits.{$this->getServiceName()}.requests_per_second", 50);
        RateLimiter::attempt($this->getServiceName(), $maxAttempts, fn (): bool => true);

        try {
            $client = $this->buildHttpClient();
            $methodLower = strtolower($method);

            /** @var Response $response */
            $response = $client->{$methodLower}($url, $params);

            if (! $response->successful()) {
                throw new \RuntimeException("Richiesta fallita a {$this->getServiceName()}: ".(string) $response->status());
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
        } catch (\Throwable $e) {
            throw new \RuntimeException("Errore durante la richiesta a {$this->getServiceName()}: ".$e->getMessage(), 0, $e);
        }
    }

    protected function buildHttpClient(): PendingRequest
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
     * @param array<string, mixed> $params
     */
    protected function getCacheKey(string $method, string $url, array $params): string
    {
        /** @var string $prefix */
        $prefix = config('geo.cache.prefix', 'geo_');
        $hash = md5($method.$url.serialize($params));

        return "{$prefix}{$this->getServiceName()}_{$hash}";
    }
}
