<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Here;

use Illuminate\Support\Facades\Http;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Durata e lunghezza percorso via HERE Routing API v8.
 *
 * Sostituisce HereService::getDurationAndLength().
 */
final class GetHereRouteSummaryAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>|null
     */
    public function execute(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        $apiKey = app(ResolveTenantConfigValueAction::class)->execute('services.here.api_key');

        $data = [
            'transportMode' => 'car',
            'origin' => $lat1.','.$lon1,
            'destination' => $lat2.','.$lon2,
            'return' => 'summary',
            'apiKey' => $apiKey,
        ];

        $response = Http::get('https://router.hereapi.com/v8/routes', $data);
        if (! method_exists($response, 'json')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        $json = $response->json();
        if (! is_array($json)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (! isset($json['routes']) || ! is_array($json['routes'])) {
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
            if (is_string($key)) {
                $res[$key] = $value;
            }
        }

        return $res;
    }
}
