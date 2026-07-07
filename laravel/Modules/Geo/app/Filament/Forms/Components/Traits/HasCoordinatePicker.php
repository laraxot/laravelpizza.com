<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Renderless;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Trait HasCoordinatePicker - Shared logic for geographic components.
 * Rule: No "Default" prefixes for configuration methods.
 * Rule: Unified state {latitude, longitude}.
 */
trait HasCoordinatePicker
{
    protected ?string $latitude = null;

    protected ?string $longitude = null;

    protected float $centerLatitude = 41.9028;

    protected float $centerLongitude = 12.4964;

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

    protected string $latitudeColumn = 'latitude';

    protected string $longitudeColumn = 'longitude';

    protected bool $geolocateWhenEmpty = false;

    /** Mostra il pannello ricerca indirizzi sul componente Lit (MapPicker / GeopointPicker / …). */
    protected bool $searchVisible = true;

    protected function setUpCoordinatePicker(): void
    {
        $this->default(['latitude' => null, 'longitude' => null]);
        // Note: Removed $this->dehydrated(false) to allow location data to be saved.
        // The component now properly persists coordinates to the form state.

        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if (\is_array($state) && isset($state['latitude'], $state['longitude'])) {
                return;
            }

            $record = $component->getRecord();
            if ($record instanceof Model) {
                $component->state([
                    'latitude' => self::normalizeCoordinate($record->getAttribute($component->getLatitudeColumn())),
                    'longitude' => self::normalizeCoordinate($record->getAttribute($component->getLongitudeColumn())),
                ]);

                return;
            }

            // No coordinates available yet: keep nulls and let the UI decide how to center
            // (e.g. geolocation when enabled, otherwise a JS-level fallback).
            $component->state(['latitude' => null, 'longitude' => null]);
        });
    }

    public function latitudeColumn(string $column): static
    {
        $this->latitudeColumn = $column;

        return $this;
    }

    public function longitudeColumn(string $column): static
    {
        $this->longitudeColumn = $column;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Set the initial map center.
     * Supports both center(lat, lng) and center(['lat' => ..., 'lng' => ...]).
     *
     * @param float|array<string, float> $latitude
     */
    public function center(float|array $latitude, ?float $longitude = null): static
    {
        if (\is_array($latitude)) {
            $this->centerLatitude = $latitude['latitude'] ?? $latitude['lat'] ?? $this->centerLatitude;
            $this->centerLongitude = $latitude['longitude'] ?? $latitude['lng'] ?? $this->centerLongitude;

            return $this;
        }

        $this->centerLatitude = $latitude;
        $this->centerLongitude = $longitude ?? $this->centerLongitude;

        return $this;
    }

    public function reverseGeocoding(bool $condition = true): static
    {
        $this->hasReverseGeocoding = $condition;

        return $this;
    }

    public function height(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function geolocateWhenEmpty(bool $condition = true): static
    {
        $this->geolocateWhenEmpty = $condition;

        return $this;
    }

    public function showSearch(bool $visible = true): static
    {
        $this->searchVisible = $visible;

        return $this;
    }

    public function isSearchVisible(): bool
    {
        return $this->searchVisible;
    }

    public function getLatitudeColumn(): string
    {
        return $this->latitudeColumn;
    }

    public function getLongitudeColumn(): string
    {
        return $this->longitudeColumn;
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

    public function getCenterLatitude(): float
    {
        return $this->centerLatitude;
    }

    public function getCenterLongitude(): float
    {
        return $this->centerLongitude;
    }

    public function hasReverseGeocoding(): bool
    {
        return $this->hasReverseGeocoding;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function getGeolocateWhenEmpty(): bool
    {
        return $this->geolocateWhenEmpty;
    }

    public function getLatitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['latitude'] ?? null);
    }

    public function getLongitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['longitude'] ?? null);
    }

    /**
     * Searches for addresses matching the query string via Nominatim.
     * Server-side to respect rate-limiting and User-Agent policies.
     *
     * @return list<array<string, mixed>>
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function searchAddress(string $query): array
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
     * Reverse geocodes coordinates to a structured address.
     * Returns a rich array for better form integration.
     *
     * @return array<string, mixed>|null
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function reverseGeocode(float $latitude, float $longitude): ?array
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
     * @param array<int, string>   $keys
     */
    private static function firstString(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            $value = $data[$key] ?? null;
            if (\is_string($value) && '' !== trim($value)) {
                return $value;
            }
        }

        return '';
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

    private static function normalizeCoordinate(mixed $value): ?float
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
