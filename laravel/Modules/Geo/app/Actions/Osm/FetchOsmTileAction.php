<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Osm;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Safe\Exceptions\DatetimeException;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;
use function Safe\preg_match;
use function Safe\strtotime;

/**
 * Un tile OpenStreetMap servito dal nostro server, con cache su disco.
 *
 * Regole della Tile Usage Policy di OSMF (operations.osmfoundation.org/policies/tiles):
 * - User-Agent che identifica il servizio con un contatto (BuildOsmUserAgentAction); Referer inoltrato, mai tolto;
 * - cache che rispetta Cache-Control/Expires e, se mancano, almeno 7 giorni (`min_cache_days`);
 * - alla scadenza richiesta condizionale (If-None-Match / If-Modified-Since): un 304 rinnova la cache;
 * - nessun pre-scaricamento: si scarica solo il tile chiesto da una mappa.
 * Se OSM non risponde si serve la copia scaduta, se c'e'.
 *
 * Il chiamante valida z/x/y (OsmTileController); qui si assume un tile esistente.
 *
 * @contract docs/contracts/fetch-osm-tile-action.md
 * Contratto di comportamento (sei sezioni: input, output, invarianti, effetti
 * collaterali, errori, non fa).
 */
final class FetchOsmTileAction
{
    public function __construct(private readonly BuildOsmUserAgentAction $userAgent) {}

    /**
     * @return array{body: string, etag: ?string, last_modified: ?string}|null null se il tile non e' disponibile
     */
    public function execute(int $z, int $x, int $y, ?string $referer = null): ?array
    {
        $disk = Storage::disk('local');
        $path = "geo/osm-tiles/{$z}/{$x}/{$y}.png";
        $metaPath = $path.'.json';
        $meta = $this->readMeta($disk->exists($metaPath) ? (string) $disk->get($metaPath) : null);
        $cached = $disk->exists($path) ? (string) $disk->get($path) : null;

        if ($cached !== null && $meta !== null && $meta['expires_at'] > Carbon::now()->getTimestamp()) {
            return ['body' => $cached, 'etag' => $meta['etag'], 'last_modified' => $meta['last_modified']];
        }

        $headers = ['User-Agent' => $this->userAgent->execute()];
        if (is_string($referer) && $referer !== '') {
            $headers['Referer'] = $referer;
        }
        if ($cached !== null && $meta !== null) {
            if ($meta['etag'] !== null) {
                $headers['If-None-Match'] = $meta['etag'];
            }
            if ($meta['last_modified'] !== null) {
                $headers['If-Modified-Since'] = $meta['last_modified'];
            }
        }

        $url = str_replace(['{z}', '{x}', '{y}'], [(string) $z, (string) $x, (string) $y], $this->upstream());

        try {
            $response = Http::withHeaders($headers)->timeout($this->timeout())->get($url);
        } catch (ConnectionException $exception) {
            Log::warning('OSM tile upstream unreachable', ['tile' => "{$z}/{$x}/{$y}", 'error' => $exception->getMessage()]);

            return $this->stale($cached, $meta);
        }

        if ($response->status() === 304 && $cached !== null && $meta !== null) {
            $fresh = ['expires_at' => $this->expiresAt($response), 'etag' => $this->header($response, 'ETag') ?? $meta['etag'], 'last_modified' => $this->header($response, 'Last-Modified') ?? $meta['last_modified']];
            $disk->put($metaPath, (string) json_encode($fresh, JSON_THROW_ON_ERROR));

            return ['body' => $cached, 'etag' => $fresh['etag'], 'last_modified' => $fresh['last_modified']];
        }

        if (! $response->successful() || ! str_starts_with((string) $response->header('Content-Type'), 'image/')) {
            Log::warning('OSM tile upstream error', ['tile' => "{$z}/{$x}/{$y}", 'status' => $response->status()]);

            return $this->stale($cached, $meta);
        }

        $body = $response->body();
        $fresh = ['expires_at' => $this->expiresAt($response), 'etag' => $this->header($response, 'ETag'), 'last_modified' => $this->header($response, 'Last-Modified')];
        $disk->put($path, $body);
        $disk->put($metaPath, (string) json_encode($fresh, JSON_THROW_ON_ERROR));

        return ['body' => $body, 'etag' => $fresh['etag'], 'last_modified' => $fresh['last_modified']];
    }

    /**
     * Scadenza dalla risposta (max-age, poi Expires), mai prima di `min_cache_days` giorni.
     */
    private function expiresAt(Response $response): int
    {
        $now = Carbon::now()->getTimestamp();
        $minimum = $now + $this->minCacheDays() * 86400;
        $declared = null;

        if (preg_match('/max-age=(\d+)/', (string) $response->header('Cache-Control'), $match) === 1 && isset($match[1])) {
            $declared = $now + (int) $match[1];
        } elseif (($expires = $this->header($response, 'Expires')) !== null) {
            try {
                $declared = strtotime($expires);
            } catch (DatetimeException) {
                // Expires illeggibile: vale il minimo
            }
        }

        return max($minimum, $declared ?? $minimum);
    }

    /**
     * @param  array{expires_at: int, etag: ?string, last_modified: ?string}|null  $meta
     * @return array{body: string, etag: ?string, last_modified: ?string}|null
     */
    private function stale(?string $cached, ?array $meta): ?array
    {
        return $cached === null ? null : ['body' => $cached, 'etag' => $meta['etag'] ?? null, 'last_modified' => $meta['last_modified'] ?? null];
    }

    /**
     * @return array{expires_at: int, etag: ?string, last_modified: ?string}|null
     */
    private function readMeta(?string $json): ?array
    {
        if ($json === null) {
            return null;
        }
        try {
            $data = json_decode($json, true);
        } catch (JsonException) {
            return null;
        }
        if (! is_array($data) || ! is_int($data['expires_at'] ?? null)) {
            return null;
        }

        return [
            'expires_at' => $data['expires_at'],
            'etag' => is_string($data['etag'] ?? null) ? $data['etag'] : null,
            'last_modified' => is_string($data['last_modified'] ?? null) ? $data['last_modified'] : null,
        ];
    }

    private function header(Response $response, string $name): ?string
    {
        $value = trim((string) $response->header($name));

        return $value === '' ? null : $value;
    }

    private function upstream(): string
    {
        $value = config('geo.config.osm_proxy.tiles.upstream');

        return is_string($value) && $value !== '' ? $value : 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
    }

    private function minCacheDays(): int
    {
        $value = config('geo.config.osm_proxy.tiles.min_cache_days');

        return is_numeric($value) ? max(7, (int) $value) : 7;
    }

    private function timeout(): int
    {
        $value = config('geo.config.osm_proxy.timeout');

        return is_numeric($value) ? max(1, (int) $value) : 10;
    }
}
