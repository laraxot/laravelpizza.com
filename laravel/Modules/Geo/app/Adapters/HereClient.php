<?php

declare(strict_types=1);

namespace Modules\Geo\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;

/**
 * Adapter per l'API HERE Routing (durata e lunghezza percorso).
 */
class HereClient
{
    public string $base_url = 'https://router.hereapi.com/v8/routes';

    /**
     * @return array<string, mixed>|null
     */
    public function getDurationAndLength(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        $api_key = app(ResolveTenantConfigValueAction::class)->execute('services.here.api_key');

        $data = [
            'transportMode' => 'car',
            'origin' => $lat1.','.$lon1,
            'destination' => $lat2.','.$lon2,
            'return' => 'summary',
            'apiKey' => $api_key,
        ];

        $response = Http::get($this->base_url, $data);
        if (! method_exists($response, 'json')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        $json = $response->json();
        if (! \is_array($json)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (! isset($json['routes'])) {
            Log::warning('HereClient: routes not found in response', ['json' => $json]);

            return null;
        }
        if (! is_array($json['routes'])) {
            return null;
        }
        if (! isset($json['routes'][0]) || ! is_array($json['routes'][0])) {
            return null;
        }

        $sections = $json['routes'][0]['sections'] ?? null;
        if (! is_array($sections) || ! isset($sections[0]) || ! is_array($sections[0])) {
            return null;
        }

        $summary = $sections[0]['summary'] ?? null;
        if (! is_array($summary)) {
            return null;
        }

        $res = [];
        foreach ($summary as $key => $value) {
            if (\is_string($key)) {
                $res[$key] = $value;
            }
        }

        return $res;
    }
}
