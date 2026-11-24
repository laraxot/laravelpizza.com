<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components\Traits;

use Filament\Support\Components\Attributes\Exposed;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Renderless;
use Modules\Geo\Filament\Forms\Components\CoordinatePickerHelpers;

/**
 * Shared Filament field behaviour for map/coordinate pickers.
 *
 * Business logic and typed array shapes live in {@see CoordinatePickerHelpers}
 * (concrete class): PHPStan L10 does not reliably keep iterable value types on
 * large trait method bodies. Keep #[Exposed]/#[Renderless] wrappers here.
 *
 * Always `use` CoordinatePickerHelpers: an unqualified call resolves under
 * Traits\ and becomes class.notFound (× every consumer component).
 */
trait HasCoordinatePicker
{
    protected ?string $latitude = null;

    protected ?string $longitude = null;

    protected ?float $centerLatitude = null;

    protected ?float $centerLongitude = null;

    protected int $zoom = 13;

    protected string $height = '400px';

    protected bool $hasReverseGeocoding = true;

    protected string $latitudeColumn = 'latitude';

    protected string $longitudeColumn = 'longitude';

    protected bool $geolocateWhenEmpty = false;

    /** Mostra il pannello ricerca indirizzi sul componente Lit (MapPicker / GeopointPicker / …). */
    protected bool $searchVisible = true;

    /**
     * Hydrates the composite latitude/longitude state from the bound model.
     *
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
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
     * @param  float|array{latitude?: float|int|string, lat?: float|int|string, longitude?: float|int|string, lng?: float|int|string}  $latitude
<<<<<<< .merge_file_IzCHoQ
<<<<<<< .merge_file_PvvYte
<<<<<<< .merge_file_UT8Zyq
     *
=======
>>>>>>> .merge_file_5l6Vjl
=======
>>>>>>> .merge_file_mR1eJ0
=======
>>>>>>> .merge_file_wpWmQe
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    public function center(float|array $latitude, ?float $longitude = null): static
    {
        if (\is_array($latitude)) {
            $centerLatitude = CoordinatePickerHelpers::normalizeCoordinate($latitude['latitude'] ?? $latitude['lat'] ?? null);
            if ($centerLatitude !== null) {
                $this->centerLatitude = $centerLatitude;
            }

            $centerLongitude = CoordinatePickerHelpers::normalizeCoordinate($latitude['longitude'] ?? $latitude['lng'] ?? null);
            if ($centerLongitude !== null) {
                $this->centerLongitude = $centerLongitude;
            }

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

    public function getCenterLatitude(): ?float
    {
        return $this->centerLatitude;
    }

    public function getCenterLongitude(): ?float
    {
        return $this->centerLongitude;
    }

    /**
     * Vista di partenza quando non c'e' un punto: `geo.config.map.default_view`, fallback Italia.
     *
     * @return array{lat: float, lng: float, zoom: int}
<<<<<<< .merge_file_IzCHoQ
<<<<<<< .merge_file_PvvYte
<<<<<<< .merge_file_UT8Zyq
     *
=======
>>>>>>> .merge_file_5l6Vjl
=======
>>>>>>> .merge_file_mR1eJ0
=======
>>>>>>> .merge_file_wpWmQe
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    public function getMapDefaultView(): array
    {
        $configuredView = config('geo.config.map.default_view');
        if (! \is_array($configuredView)) {
            $view = null;
        } else {
            /** @var array<string, mixed> $configuredView */
            $view = self::mapDefaultViewInput($configuredView);
        }
        $lat = $view === null ? null : CoordinatePickerHelpers::normalizeCoordinate($view['lat']);
        $lng = $view === null ? null : CoordinatePickerHelpers::normalizeCoordinate($view['lng']);
        $rawZoom = $view === null ? null : $view['zoom'];
        $zoom = is_numeric($rawZoom) ? (float) $rawZoom : null;

        if ($lat === null || $lng === null || $zoom === null
            || abs($lat) > 90 || abs($lng) > 180 || $zoom !== floor($zoom) || $zoom < 1 || $zoom > 19) {
            return ['lat' => 42.5, 'lng' => 12.5, 'zoom' => 6];
        }

        return ['lat' => $lat, 'lng' => $lng, 'zoom' => (int) $zoom];
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

    /**
     * Reads and normalizes the latitude from the composite picker state.
     *
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    public function getLatitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        /** @var array<string, mixed> $state */
        return CoordinatePickerHelpers::normalizeCoordinate($state['latitude'] ?? null);
    }

    /**
     * Reads and normalizes the longitude from the composite picker state.
     *
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    public function getLongitude(): ?float
    {
        $state = $this->getState();
        if (! \is_array($state)) {
            return null;
        }

        /** @var array<string, mixed> $state */
        return CoordinatePickerHelpers::normalizeCoordinate($state['longitude'] ?? null);
    }

    /**
     * @return list<array<string, mixed>>
<<<<<<< .merge_file_IzCHoQ
<<<<<<< .merge_file_PvvYte
<<<<<<< .merge_file_UT8Zyq
     *
=======
>>>>>>> .merge_file_5l6Vjl
=======
>>>>>>> .merge_file_mR1eJ0
=======
>>>>>>> .merge_file_wpWmQe
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    #[Exposed]
    #[Renderless]
    public function searchAddress(string $query): array
    {
        return CoordinatePickerHelpers::searchAddress($query);
    }

    /**
     * @return array<string, mixed>|null
<<<<<<< .merge_file_IzCHoQ
<<<<<<< .merge_file_PvvYte
<<<<<<< .merge_file_UT8Zyq
     *
=======
>>>>>>> .merge_file_5l6Vjl
=======
>>>>>>> .merge_file_mR1eJ0
=======
>>>>>>> .merge_file_wpWmQe
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    #[Exposed]
    #[Renderless]
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        return CoordinatePickerHelpers::reverseGeocode($latitude, $longitude);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
<<<<<<< .merge_file_IzCHoQ
<<<<<<< .merge_file_PvvYte
<<<<<<< .merge_file_UT8Zyq
     *
=======
>>>>>>> .merge_file_5l6Vjl
=======
>>>>>>> .merge_file_mR1eJ0
=======
>>>>>>> .merge_file_wpWmQe
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    public static function extractCoordinates(array $data, string $field = 'coordinates', string $latColumn = 'latitude', string $lngColumn = 'longitude'): array
    {
        return CoordinatePickerHelpers::extractCoordinates($data, $field, $latColumn, $lngColumn);
    }

    /**
     * Validates the configuration boundary before the view is normalized.
     *
     * @param  array<string, mixed>  $view
     * @return array{lat: float|int|string, lng: float|int|string, zoom: float|int|string}|null
<<<<<<< .merge_file_IzCHoQ
<<<<<<< .merge_file_PvvYte
<<<<<<< .merge_file_UT8Zyq
     *
=======
>>>>>>> .merge_file_5l6Vjl
=======
>>>>>>> .merge_file_mR1eJ0
=======
>>>>>>> .merge_file_wpWmQe
     * @see ../../../../../docs/coordinate-picker-purpose.md
     */
    private static function mapDefaultViewInput(array $view): ?array
    {
        $lat = $view['lat'] ?? null;
        $lng = $view['lng'] ?? null;
        $zoom = $view['zoom'] ?? null;

        if (! is_numeric($lat) || ! is_numeric($lng) || ! is_numeric($zoom)) {
            return null;
        }

        return ['lat' => $lat, 'lng' => $lng, 'zoom' => $zoom];
    }
}
