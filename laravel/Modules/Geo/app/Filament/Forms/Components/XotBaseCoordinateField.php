<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Renderless;
use Modules\Geo\Filament\Forms\Components\Support\CoordinatePickerHelpers;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * Base field for geographic coordinate pickers (map, lat/lng, geopoint).
 */
abstract class XotBaseCoordinateField extends XotBaseField
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

    protected bool $searchVisible = true;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCoordinatePicker();
    }

    protected function setUpCoordinatePicker(): void
    {
        $this->default(['latitude' => null, 'longitude' => null]);

        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if (\is_array($state) && isset($state['latitude'], $state['longitude'])) {
                return;
            }

            $record = $component->getRecord();
            if ($record instanceof Model) {
                $component->state([
                    'latitude' => CoordinatePickerHelpers::normalizeCoordinate($record->getAttribute($component->getLatitudeColumn())),
                    'longitude' => CoordinatePickerHelpers::normalizeCoordinate($record->getAttribute($component->getLongitudeColumn())),
                ]);

                return;
            }

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
     * @param float|array{latitude?: float|int|string, lat?: float|int|string, longitude?: float|int|string, lng?: float|int|string} $latitude
     */
    public function center(float|array $latitude, ?float $longitude = null): static
    {
        if (\is_array($latitude)) {
            $this->centerLatitude = CoordinatePickerHelpers::resolveCenterLatitude($latitude, $this->centerLatitude);
            $this->centerLongitude = CoordinatePickerHelpers::resolveCenterLongitude($latitude, $this->centerLongitude);

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

        return CoordinatePickerHelpers::normalizeCoordinate($state['latitude'] ?? null);
    }

    public function getLongitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        return CoordinatePickerHelpers::normalizeCoordinate($state['longitude'] ?? null);
    }

    /**
     * @return list<array<string, mixed>>
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function searchAddress(string $query): array
    {
        return CoordinatePickerHelpers::searchAddress($query);
    }

    /**
     * @return array<string, mixed>|null
     */
    #[ExposedLivewireMethod]
    #[Renderless]
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        return CoordinatePickerHelpers::reverseGeocode($latitude, $longitude);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public static function extractCoordinates(array $data, string $field = 'coordinates', string $latColumn = 'latitude', string $lngColumn = 'longitude'): array
    {
        return CoordinatePickerHelpers::extractCoordinates($data, $field, $latColumn, $lngColumn);
    }
}
