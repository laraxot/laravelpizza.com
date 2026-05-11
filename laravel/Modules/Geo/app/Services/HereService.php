<?php

declare(strict_types=1);

namespace Modules\Geo\Services;

use Illuminate\Support\Facades\Http;
use Modules\Tenant\Services\TenantService;

class HereService
{
    public string $base_url = 'https://router.hereapi.com/v8/routes';

    // https://router.hereapi.com/v8/routes?transportMode=car&origin=52.5308,13.3847&destination=52.5323,13.3789&return=summary

    public static function getDurationAndLength(float $lat1, float $lon1, float $lat2, float $lon2): ?array
    {
        $api_key = TenantService::config('services.here.api_key');

        $data = [
            'transportMode' => 'car',
            'origin' => $lat1.','.$lon1,
            'destination' => $lat2.','.$lon2,
            'return' => 'summary',
            'apiKey' => $api_key,
        ];

        // dddx(TenantService::config('services.here'));

        $base_url = 'https://router.hereapi.com/v8/routes';
        $response = Http::get($base_url, $data);
        if (! method_exists($response, 'json')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        $json = $response->json();
        if (! \is_array($json)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        if (! isset($json['routes']) || ! \is_array($json['routes'])) {
            return null;
        }

        /** @var array<int, mixed> $routes */
        $routes = $json['routes'];
        $firstRoute = $routes[0] ?? null;
        if (! \is_array($firstRoute)) {
            return null;
        }

        if (! isset($firstRoute['sections']) || ! \is_array($firstRoute['sections'])) {
            return null;
        }

        /** @var array<int, mixed> $sections */
        $sections = $firstRoute['sections'];
        $firstSection = $sections[0] ?? null;
        if (! \is_array($firstSection)) {
            return null;
        }

        if (! isset($firstSection['summary']) || ! \is_array($firstSection['summary'])) {
            return null;
        }

        /** @var array<string, mixed> $summary */
        $summary = $firstSection['summary'];

        return $summary;
    }
}
