<?php

declare(strict_types=1);

namespace Modules\Geo\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

class CoordinatePicker extends Field
{
    public ?string $latitudeColumn = 'latitude';

    public ?string $longitudeColumn = 'longitude';

    public int $zoom = 13;

    public bool $showFullscreenButton = true;

    public bool $showLocateButton = true;

    public bool $enableReverseGeocoding = false;

    protected string $view = 'geo::filament.forms.components.coordinate-picker';

    protected ?float $latitude = null;

    protected ?float $longitude = null;

    public function latitudeColumn(?string $column = null): static
    {
        $this->latitudeColumn = $column;

        return $this;
    }

    public function longitudeColumn(?string $column = null): static
    {
        $this->longitudeColumn = $column;

        return $this;
    }

    public function zoom(int $zoom): static
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function showFullscreenButton(bool $show = true): static
    {
        $this->showFullscreenButton = $show;

        return $this;
    }

    public function showLocateButton(bool $show = true): static
    {
        $this->showLocateButton = $show;

        return $this;
    }

    public function enableReverseGeocoding(bool $enable = true): static
    {
        $this->enableReverseGeocoding = $enable;

        return $this;
    }

    public function hasReverseGeocoding(): bool
    {
        return $this->enableReverseGeocoding;
    }

    public function getStatePath(bool $isAbsolute = true): string
    {
        return $this->getName().'.coordinates';
    }

    /**
     * @return array<string, float|null>
     */
    public function getState(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules(['nullable', 'array']);
    }

    /**
     * @param array<string, mixed> $input
     */
    protected function mutateState(array $input): void
    {
        $this->latitude = isset($input['latitude']) ? SafeFloatCastAction::cast($input['latitude']) : null;
        $this->longitude = isset($input['longitude']) ? SafeFloatCastAction::cast($input['longitude']) : null;
    }

    /**
     * @param array<string, mixed> $coords
     */
    #[On('coords-changed')]
    public function handleCoordsChanged(array $coords): void
    {
        $this->latitude = isset($coords['latitude']) ? SafeFloatCastAction::cast($coords['latitude']) : null;
        $this->longitude = isset($coords['longitude']) ? SafeFloatCastAction::cast($coords['longitude']) : null;
    }

    /**
     * @return array<string, mixed>|null
     */
    #[On('reverse-geocode')]
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => \sprintf('%s/1.0 (%s)', SafeStringCastAction::cast(config('app.name', 'Laraxot')), SafeStringCastAction::cast(config('app.url', 'localhost'))),
            ])
                ->timeout(10)
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'format' => 'json',
                    'addressdetails' => 1,
                    'zoom' => 18,
                ]);

            if (! $response->successful()) {
                return null;
            }

            /** @var array<string, mixed>|null $data */
            $data = $response->json();
            if (! is_array($data)) {
                return null;
            }

            $displayName = $data['display_name'] ?? null;
            if (! is_string($displayName) || '' === trim($displayName)) {
                return null;
            }

            return [
                'display_name' => $displayName,
                'address' => $displayName,
                'provider' => 'nominatim',
                'raw' => $data,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param array<mixed> $data
     *
     * @return array<string, float|null>
     */
    public static function extractCoordinates(array $data, string $fieldName = 'coordinates', string $latitudeColumn = 'latitude', string $longitudeColumn = 'longitude'): array
    {
        if (! isset($data[$fieldName])) {
            return [$latitudeColumn => null, $longitudeColumn => null];
        }

        $coordinates = $data[$fieldName];
        $lat = data_get($coordinates, 'latitude');
        $lng = data_get($coordinates, 'longitude');

        $lat = is_numeric($lat) ? (float) $lat : null;
        $lng = is_numeric($lng) ? (float) $lng : null;

        return [$latitudeColumn => $lat, $longitudeColumn => $lng];
    }
}
