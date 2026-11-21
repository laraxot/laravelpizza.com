<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Osm;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Sleep;

use function Safe\preg_match;

/**
 * Ricerca e geocodifica inversa su Nominatim passando dal nostro server.
 *
 * Nominatim Usage Policy (operations.osmfoundation.org/policies/nominatim): al massimo 1 richiesta al secondo per
 * tutta l'applicazione, User-Agent identificabile, cache dei risultati, «set up a proxy and enable caching if at all
 * possible», servizio spegnibile senza aggiornare il software (`geo.config.osm_proxy.nominatim.enabled`). Solo i
 * parametri ammessi passano; il formato e' sempre `json`, come lo leggono le mappe.
 *
 * Contratto di comportamento: docs/contracts/query-nominatim-action.md (sei sezioni: input, output, invarianti, effetti
 * collaterali, errori, non fa).
 */
final class QueryNominatimAction
{
    public const string RATE_LIMIT_KEY = 'geo:nominatim:upstream';

    /** @var array<string, list<string>> */
    private const array ALLOWED = [
        'search' => ['q', 'limit', 'addressdetails', 'countrycodes', 'viewbox', 'bounded'],
        'reverse' => ['lat', 'lon', 'zoom', 'addressdetails'],
    ];

    public function __construct(private readonly BuildOsmUserAgentAction $userAgent) {}

    /**
     * @param  'search'|'reverse'  $endpoint
     * @param  array<string, mixed>  $input
     * @return array{status: int, data: mixed}
     */
    public function execute(string $endpoint, array $input, string $language): array
    {
        if (! (bool) config('geo.config.osm_proxy.nominatim.enabled', true)) {
            return ['status' => 503, 'data' => ['error' => 'geocoding disabled']];
        }

        $params = $this->params($endpoint, $input);
        if ($params === null) {
            return ['status' => 422, 'data' => ['error' => 'invalid parameters']];
        }
        $params['format'] = 'json';
        $params['accept-language'] = $this->language($language);
        ksort($params);

        $cacheKey = 'geo:nominatim:'.$endpoint.':'.sha1((string) json_encode($params, JSON_THROW_ON_ERROR));
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return ['status' => 200, 'data' => $cached];
        }

        // 1 richiesta al secondo per tutta l'app: se il posto e' occupato si aspetta il secondo successivo, una volta.
        if (! $this->takeSlot()) {
            Sleep::for(1)->second();
            if (! $this->takeSlot()) {
                return ['status' => 429, 'data' => ['error' => 'busy, retry']];
            }
        }

        try {
            $response = Http::withHeaders(['User-Agent' => $this->userAgent->execute()])
                ->timeout($this->timeout())
                ->get($this->upstream().'/'.$endpoint, $params);
        } catch (ConnectionException $exception) {
            Log::warning('Nominatim upstream unreachable', ['endpoint' => $endpoint, 'error' => $exception->getMessage()]);

            return ['status' => 502, 'data' => ['error' => 'upstream unreachable']];
        }

        if (! $response->successful()) {
            Log::warning('Nominatim upstream error', ['endpoint' => $endpoint, 'status' => $response->status()]);

            return ['status' => 502, 'data' => ['error' => 'upstream error']];
        }

        $data = $response->json();
        Cache::put($cacheKey, $data, now()->addDays($this->cacheDays()));

        return ['status' => 200, 'data' => $data];
    }

    /**
     * @param  array<string, mixed>  $input
     * @return array<string, string>|null
     */
    private function params(string $endpoint, array $input): ?array
    {
        $allowed = self::ALLOWED[$endpoint] ?? null;
        if ($allowed === null) {
            return null;
        }

        $params = [];
        foreach ($allowed as $name) {
            $value = $input[$name] ?? null;
            if (is_scalar($value) && trim((string) $value) !== '') {
                $params[$name] = trim((string) $value);
            }
        }

        if ($endpoint === 'search') {
            if (! isset($params['q']) || mb_strlen($params['q']) < 3 || mb_strlen($params['q']) > 200) {
                return null;
            }
            $params['limit'] = (string) min(10, max(1, (int) ($params['limit'] ?? 5)));

            return $params;
        }

        $lat = $params['lat'] ?? null;
        $lon = $params['lon'] ?? null;
        if (! is_numeric($lat) || ! is_numeric($lon) || abs((float) $lat) > 90 || abs((float) $lon) > 180) {
            return null;
        }
        if (isset($params['zoom'])) {
            $params['zoom'] = (string) min(18, max(0, (int) $params['zoom']));
        }

        return $params;
    }

    /** @phpstan-impure */
    private function takeSlot(): bool
    {
        if (RateLimiter::tooManyAttempts(self::RATE_LIMIT_KEY, 1)) {
            return false;
        }
        RateLimiter::hit(self::RATE_LIMIT_KEY, 1);

        return true;
    }

    private function language(string $language): string
    {
        $language = strtolower(substr(trim($language), 0, 2));

        return preg_match('/^[a-z]{2}$/', $language) === 1 ? $language : 'it';
    }

    private function upstream(): string
    {
        $value = config('geo.config.osm_proxy.nominatim.upstream');

        return rtrim(is_string($value) && $value !== '' ? $value : 'https://nominatim.openstreetmap.org', '/');
    }

    private function cacheDays(): int
    {
        $value = config('geo.config.osm_proxy.nominatim.cache_days');

        return is_numeric($value) ? max(1, (int) $value) : 30;
    }

    private function timeout(): int
    {
        $value = config('geo.config.osm_proxy.timeout');

        return is_numeric($value) ? max(1, (int) $value) : 10;
    }
}
