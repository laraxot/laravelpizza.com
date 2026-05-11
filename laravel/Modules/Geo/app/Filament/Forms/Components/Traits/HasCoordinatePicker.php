<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Renderless;

/**
 * Trait HasCoordinatePicker - Shared logic for geographic components.
 * Standardized on 'lat' and 'lng' for keys and properties.
 * JSON-first: Saves to a single field as array/JSON by default.
 */
trait HasCoordinatePicker
{
    protected float $centerLat = 41.9028;

    protected float $centerLng = 12.4964;

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

    protected ?string $latColumn = null;

    protected ?string $lngColumn = null;

    protected bool $geolocateWhenEmpty = false;

    public function latColumn(string $column): static
    {
        $this->latColumn = $column;

        return $this;
    }

    public function lngColumn(string $column): static
    {
        $this->lngColumn = $column;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Set the initial map center.
     *
     * @param float|array<string, float> $lat
     */
    public function center(float|array $lat, ?float $lng = null): static
    {
        if (is_array($lat)) {
            $this->centerLat = $lat['lat'] ?? $this->centerLat;
            $this->centerLng = $lat['lng'] ?? $this->centerLng;

            return $this;
        }

        $this->centerLat = $lat;
        $this->centerLng = $lng ?? $this->centerLng;

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

    public function getLatColumn(): ?string
    {
        return $this->latColumn;
    }

    public function getLngColumn(): ?string
    {
        return $this->lngColumn;
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

    public function getCenterLat(): float
    {
        return $this->centerLat;
    }

    public function getCenterLng(): float
    {
        return $this->centerLng;
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
    }

    /**
     * Searches for addresses matching the query string via Nominatim.
     *
     * @return array<int, array<string, mixed>>
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function searchAddress(string $query): array
    {
        if (strlen(trim($query)) < 3) {
            return [];
        }

        try {
            $appNameConfig = config('app.name');
            $appUrlConfig = config('app.url');
            $appName = is_string($appNameConfig) && '' !== $appNameConfig ? $appNameConfig : 'Laraxot';
            $appUrl = is_string($appUrlConfig) && '' !== $appUrlConfig ? $appUrlConfig : 'localhost';

            $response = Http::withHeaders([
                'User-Agent' => sprintf('%s/1.0 (%s)', $appName, $appUrl),
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
            if (! is_array($data)) {
                return [];
            }

            /** @var array<int, array<string, mixed>> $normalized */
            $normalized = array_values(array_filter(
                $data,
                static fn (mixed $item): bool => is_array($item),
            ));

            return $normalized;
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Reverse geocodes coordinates to a structured address.
     *
     * @return array<string, mixed>|null
     */
    #[ExposedLivewireMethod]
    #[Renderless]
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

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Laraxot/1.0',
            ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat' => $lat,
                    'lon' => $lng,
                    'format' => 'jsonv2',
                    'addressdetails' => 1,
                    'zoom' => 18,
                ]);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();
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
                'raw' => $data,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

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

    /**
     * @param array<string, mixed> $data
     * @param array<int, string>   $keys
     */
    private static function firstString(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            $value = $data[$key] ?? null;
            if (is_string($value) && '' !== trim($value)) {
                return $value;
            }
        }

        return '';
    }

    private static function normalizeCoordinate(mixed $value): ?float
    {
        if (null === $value || '' === $value) {
            return null;
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
