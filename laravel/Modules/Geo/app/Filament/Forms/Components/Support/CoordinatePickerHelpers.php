<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Support;

use Illuminate\Support\Facades\Http;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Typed helpers for {@see \Modules\Geo\Filament\Forms\Components\XotBaseCoordinateField}.
 *
 * ponytail: extracted from trait so PHPStan L10 sees array generics on a concrete class.
 */
final class CoordinatePickerHelpers
{
    /**
     * @param array{latitude?: float|int|string, lat?: float|int|string, longitude?: float|int|string, lng?: float|int|string} $center
     */
    public static function resolveCenterLatitude(array $center, float $default): float
    {
        $lat = $center['latitude'] ?? $center['lat'] ?? null;

        return is_numeric($lat) ? (float) $lat : $default;
    }

    /**
     * @param array{latitude?: float|int|string, lat?: float|int|string, longitude?: float|int|string, lng?: float|int|string} $center
     */
    public static function resolveCenterLongitude(array $center, float $default): float
    {
        $lng = $center['longitude'] ?? $center['lng'] ?? null;

        return is_numeric($lng) ? (float) $lng : $default;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function searchAddress(string $query): array
    {
        if (\strlen(trim($query)) < 3) {
            return [];
        }

        try {
            $appName = SafeStringCastAction::cast(config('app.name', 'Laraxot'));
            $appUrl = SafeStringCastAction::cast(config('app.url', 'localhost'));
            $response = Http::withHeaders([
                'User-Agent' => \sprintf('%s/1.0 (%s)', $appName, $appUrl),
            ])
                ->timeout(10)
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query,
                    'format' => 'json',
                    'addressdetails' => 1,
                    'limit' => 5,
                ]);

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json();

            if (! \is_array($data)) {
                return [];
            }

            $filtered = array_values(array_filter($data, static fn (mixed $item): bool => \is_array($item)));

            /** @var list<array<string, mixed>> $results */
            $results = [];
            foreach ($filtered as $item) {
                if (! \is_array($item)) {
                    continue;
                }

                /** @var array<string, mixed> $row */
                $row = $item;
                $results[] = $row;
            }

            return $results;
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function reverseGeocode(float $latitude, float $longitude): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Laraxot/1.0',
            ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'format' => 'jsonv2',
                    'addressdetails' => 1,
                    'zoom' => 18,
                ]);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();
            if (! \is_array($data)) {
                return null;
            }

            /** @var array<string, mixed> $address */
            $address = $data['address'] ?? [];
            if (! \is_array($address)) {
                $address = [];
            }

            return [
                'display_name' => \is_string($data['display_name'] ?? null) ? $data['display_name'] : '',
                'address' => \is_string($data['display_name'] ?? null) ? $data['display_name'] : '',
                'provider' => 'nominatim',
                'place_id' => $data['place_id'] ?? null,
                'osm_type' => $data['osm_type'] ?? null,
                'osm_id' => $data['osm_id'] ?? null,
                'licence' => $data['licence'] ?? null,
                'importance' => is_numeric($data['importance'] ?? null) ? (float) $data['importance'] : null,
                'type' => $data['type'] ?? null,
                'class' => $data['category'] ?? $data['class'] ?? null,
                'boundingbox' => isset($data['boundingbox']) && \is_array($data['boundingbox']) ? $data['boundingbox'] : null,
                'street' => self::firstString($address, ['road', 'pedestrian', 'footway', 'path', 'residential', 'highway']),
                'street_number' => self::firstString($address, ['house_number', 'street_number']),
                'zip' => self::firstString($address, ['postcode']),
                'postcode' => self::firstString($address, ['postcode']),
                'city' => self::firstString($address, ['city', 'town', 'village', 'municipality', 'hamlet', 'county']),
                'suburb' => self::firstString($address, ['suburb', 'neighbourhood', 'quarter', 'city_district']),
                'province' => self::firstString($address, ['province', 'county', 'state_district']),
                'state' => self::firstString($address, ['state', 'region']),
                'country' => self::firstString($address, ['country']),
                'country_code' => self::firstString($address, ['country_code']),
                'structured' => [
                    'road' => self::firstString($address, ['road', 'pedestrian', 'footway', 'path', 'residential', 'highway']),
                    'house_number' => self::firstString($address, ['house_number', 'street_number']),
                    'city' => self::firstString($address, ['city', 'town', 'village', 'municipality', 'county']),
                    'postcode' => self::firstString($address, ['postcode']),
                    'state' => self::firstString($address, ['state', 'region']),
                    'country' => self::firstString($address, ['country']),
                    'city_district' => self::firstString($address, ['city_district', 'suburb', 'neighbourhood', 'quarter']),
                ],
                'address_details' => $address,
                'raw' => $data,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public static function extractCoordinates(array $data, string $field = 'coordinates', string $latColumn = 'latitude', string $lngColumn = 'longitude'): array
    {
        $coordinates = $data[$field] ?? null;
        if (\is_array($coordinates)) {
            $data[$latColumn] = self::normalizeCoordinate($coordinates['latitude'] ?? null);
            $data[$lngColumn] = self::normalizeCoordinate($coordinates['longitude'] ?? null);
        }

        return $data;
    }

    public static function normalizeCoordinate(mixed $value): ?float
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * @param array<string, mixed> $data
     * @param list<string>         $keys
     */
    private static function firstString(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            if (! \is_string($key)) {
                continue;
            }

            $value = $data[$key] ?? null;
            if (\is_string($value) && '' !== trim($value)) {
                return $value;
            }
        }

        return '';
    }
}
