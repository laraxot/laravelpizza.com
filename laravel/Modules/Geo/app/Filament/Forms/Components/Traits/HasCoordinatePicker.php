<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Renderless;
<<<<<<< HEAD

/**
 * Trait HasCoordinatePicker - Shared logic for geographic components.
 * Standardized on 'lat' and 'lng' for keys and properties.
 * JSON-first: Saves to a single field as array/JSON by default.
 */
trait HasCoordinatePicker
{
    protected float $centerLat = 41.9028;

    protected float $centerLng = 12.4964;
=======
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
>>>>>>> 40b96bcd6 (.)

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

<<<<<<< HEAD
    protected ?string $latColumn = null;

    protected ?string $lngColumn = null;

    protected bool $geolocateWhenEmpty = false;

    public function latColumn(string $column): static
    {
        $this->latColumn = $column;
=======
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
>>>>>>> 40b96bcd6 (.)

        return $this;
    }

<<<<<<< HEAD
    public function lngColumn(string $column): static
    {
        $this->lngColumn = $column;
=======
    public function longitudeColumn(string $column): static
    {
        $this->longitudeColumn = $column;
>>>>>>> 40b96bcd6 (.)

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Set the initial map center.
<<<<<<< HEAD
     *
     * @param float|array<string, float> $lat
     */
    public function center(float|array $lat, ?float $lng = null): static
    {
        if (is_array($lat)) {
            $this->centerLat = $lat['lat'] ?? $this->centerLat;
            $this->centerLng = $lat['lng'] ?? $this->centerLng;
=======
     * Supports both center(lat, lng) and center(['lat' => ..., 'lng' => ...]).
     *
     * @param float|array<string, float> $latitude
     */
    public function center(float|array $latitude, ?float $longitude = null): static
    {
        if (\is_array($latitude)) {
            $this->centerLatitude = $latitude['latitude'] ?? $latitude['lat'] ?? $this->centerLatitude;
            $this->centerLongitude = $latitude['longitude'] ?? $latitude['lng'] ?? $this->centerLongitude;
>>>>>>> 40b96bcd6 (.)

            return $this;
        }

<<<<<<< HEAD
        $this->centerLat = $lat;
        $this->centerLng = $lng ?? $this->centerLng;
=======
        $this->centerLatitude = $latitude;
        $this->centerLongitude = $longitude ?? $this->centerLongitude;
>>>>>>> 40b96bcd6 (.)

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

<<<<<<< HEAD
    public function getLatColumn(): ?string
    {
        return $this->latColumn;
    }

    public function getLngColumn(): ?string
    {
        return $this->lngColumn;
=======
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
>>>>>>> 40b96bcd6 (.)
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

<<<<<<< HEAD
    public function getCenterLat(): float
    {
        return $this->centerLat;
    }

    public function getCenterLng(): float
    {
        return $this->centerLng;
=======
    public function getCenterLatitude(): float
    {
        return $this->centerLatitude;
    }

    public function getCenterLongitude(): float
    {
        return $this->centerLongitude;
>>>>>>> 40b96bcd6 (.)
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

<<<<<<< HEAD
    public function getLat(): ?float
    {
        $state = $this->getState();
        if (! is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['lat'] ?? null);
    }

    public function getLng(): ?float
    {
        $state = $this->getState();
        if (! is_array($state)) {
            return null;
        }

        return self::normalizeCoordinate($state['lng'] ?? null);
=======
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
>>>>>>> 40b96bcd6 (.)
    }

    /**
     * Searches for addresses matching the query string via Nominatim.
<<<<<<< HEAD
     *
     * @return array<int, array<string, mixed>>
=======
     * Server-side to respect rate-limiting and User-Agent policies.
     *
     * @return list<array<string, mixed>>
>>>>>>> 40b96bcd6 (.)
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function searchAddress(string $query): array
    {
<<<<<<< HEAD
        if (strlen(trim($query)) < 3) {
=======
        if (\strlen(trim($query)) < 3) {
>>>>>>> 40b96bcd6 (.)
            return [];
        }

        try {
<<<<<<< HEAD
            $appNameConfig = config('app.name');
            $appUrlConfig = config('app.url');
            $appName = is_string($appNameConfig) && '' !== $appNameConfig ? $appNameConfig : 'Laraxot';
            $appUrl = is_string($appUrlConfig) && '' !== $appUrlConfig ? $appUrlConfig : 'localhost';

            $response = Http::withHeaders([
                'User-Agent' => sprintf('%s/1.0 (%s)', $appName, $appUrl),
=======
            $appName = SafeStringCastAction::cast(config('app.name', 'Laraxot'));
            $appUrl = SafeStringCastAction::cast(config('app.url', 'localhost'));
            $response = Http::withHeaders([
                'User-Agent' => \sprintf('%s/1.0 (%s)', $appName, $appUrl),
>>>>>>> 40b96bcd6 (.)
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
<<<<<<< HEAD
            if (! is_array($data)) {
                return [];
            }

            /** @var array<int, array<string, mixed>> $normalized */
            $normalized = array_values(array_filter(
                $data,
                static fn (mixed $item): bool => is_array($item),
            ));

            return $normalized;
=======

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
>>>>>>> 40b96bcd6 (.)
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Reverse geocodes coordinates to a structured address.
<<<<<<< HEAD
=======
     * Returns a rich array for better form integration.
>>>>>>> 40b96bcd6 (.)
     *
     * @return array<string, mixed>|null
     */
    #[ExposedLivewireMethod]
    #[Renderless]
<<<<<<< HEAD
    public function reverseGeocode(mixed $lat = null, mixed $lng = null): ?array
    {
        if (is_array($lat)) {
            $lng = $lat['lng'] ?? $lat['lon'] ?? $lat['longitude'] ?? null;
            $lat = $lat['lat'] ?? $lat['latitude'] ?? null;
        }

        if (! is_numeric($lat) || ! is_numeric($lng)) {
            return null;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

=======
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
>>>>>>> 40b96bcd6 (.)
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Laraxot/1.0',
            ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
<<<<<<< HEAD
                    'lat' => $lat,
                    'lon' => $lng,
=======
                    'lat' => $latitude,
                    'lon' => $longitude,
>>>>>>> 40b96bcd6 (.)
                    'format' => 'jsonv2',
                    'addressdetails' => 1,
                    'zoom' => 18,
                ]);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();
<<<<<<< HEAD
            if (! is_array($data)) {
                return null;
            }

            $addressRaw = $data['address'] ?? [];
            /** @var array<string, mixed> $address */
            $address = [];
            if (is_array($addressRaw)) {
                foreach ($addressRaw as $key => $value) {
                    if (is_string($key)) {
                        $address[$key] = $value;
                    }
                }
            }

            return [
                'address' => is_string($data['display_name'] ?? null) ? $data['display_name'] : '',
                'street' => self::firstString($address, ['road', 'pedestrian', 'footway', 'path', 'residential', 'highway']),
                'street_number' => self::firstString($address, ['house_number', 'street_number']),
                'city' => self::firstString($address, ['city', 'town', 'village', 'municipality', 'county']),
                'postcode' => self::firstString($address, ['postcode']),
                'state' => self::firstString($address, ['state', 'region']),
                'province' => self::firstString($address, ['province', 'county']),
                'country' => self::firstString($address, ['country']),
                'country_code' => self::firstString($address, ['country_code']),
                'suburb' => self::firstString($address, ['suburb', 'neighbourhood', 'quarter', 'city_district']),
=======
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
>>>>>>> 40b96bcd6 (.)
                'raw' => $data,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

<<<<<<< HEAD
    protected function setUpCoordinatePicker(): void
    {
        $this->default(['lat' => null, 'lng' => null, 'address' => null]);

        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if (is_array($state) && isset($state['lat'], $state['lng'])) {
                return;
            }

            $record = $component->getRecord();
            $fieldName = $component->getName();

            // Case 1: State is already a JSON/Array in the main field
            if ($record instanceof Model && is_array($val = $record->getAttribute($fieldName))) {
                $component->state([
                    'lat' => self::normalizeCoordinate($val['lat'] ?? null),
                    'lng' => self::normalizeCoordinate($val['lng'] ?? null),
                    'address' => $val['address'] ?? null,
                ]);

                return;
            }

            // Case 2: Mapping from separate columns
            if ($record instanceof Model && $component->getLatColumn() && $component->getLngColumn()) {
                $component->state([
                    'lat' => self::normalizeCoordinate($record->getAttribute($component->getLatColumn())),
                    'lng' => self::normalizeCoordinate($record->getAttribute($component->getLngColumn())),
                    'address' => $record->getAttribute('address'), // Fallback for address if it exists
                ]);

                return;
            }

            $component->state(['lat' => null, 'lng' => null, 'address' => null]);
        });

        $this->dehydrateStateUsing(static function (self $component, mixed $state): ?array {
            if (! \is_array($state)) {
                return null;
            }

            $latitude = $state['latitude'] ?? $state['lat'] ?? null;
            $longitude = $state['longitude'] ?? $state['lng'] ?? null;

            $normalized = $state;
            $normalized['latitude'] = \is_numeric($latitude) ? (string) $latitude : null;
            $normalized['longitude'] = \is_numeric($longitude) ? (string) $longitude : null;

            // Manteniamo compatibilita con codice legacy che legge lat/lng.
            $normalized['lat'] = \is_numeric($latitude) ? (float) $latitude : null;
            $normalized['lng'] = \is_numeric($longitude) ? (float) $longitude : null;

            return $normalized;
        });

        $this->saveRelationshipsUsing(static function (self $component, Model $record, $state): void {
            if (! is_array($state)) {
                return;
            }

            $latCol = $component->getLatColumn();
            $lngCol = $component->getLngColumn();

            // If separate columns are defined, update them
            if ($latCol && $lngCol) {
                $record->update([
                    $latCol => self::normalizeCoordinate($state['lat'] ?? null),
                    $lngCol => self::normalizeCoordinate($state['lng'] ?? null),
                ]);
            }
        });
    }

=======
>>>>>>> 40b96bcd6 (.)
    /**
     * @param array<string, mixed> $data
     * @param array<int, string>   $keys
     */
    private static function firstString(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            $value = $data[$key] ?? null;
<<<<<<< HEAD
            if (is_string($value) && '' !== trim($value)) {
=======
            if (\is_string($value) && '' !== trim($value)) {
>>>>>>> 40b96bcd6 (.)
                return $value;
            }
        }

        return '';
    }

<<<<<<< HEAD
=======
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

>>>>>>> 40b96bcd6 (.)
    private static function normalizeCoordinate(mixed $value): ?float
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
