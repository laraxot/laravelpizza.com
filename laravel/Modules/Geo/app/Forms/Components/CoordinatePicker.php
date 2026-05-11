<?php

declare(strict_types=1);

namespace Modules\Geo\Forms\Components;

use Filament\Forms\Components\Field;
use Livewire\Attributes\On;

use function Safe\file_get_contents;
use function Safe\json_decode;

class CoordinatePicker extends Field
{
    public ?string $latitudeColumn = 'latitude';

    public ?string $longitudeColumn = 'longitude';

    public int $zoom = 13;

    public bool $showFullscreenButton = true;

    public bool $showLocateButton = true;

    public bool $enableReverseGeocoding = false;

    protected string $view = 'geo::filament.forms.components.coordinate-picker';

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules([
            'latitude' => ['nullable', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['nullable', 'numeric', 'min:-180', 'max:180'],
        ]);
    }

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

    public function getStatePath(bool $isAbsolute = false): string
    {
        return $this->getName().'.coordinates';
    }

    public function getState(): array
    {
        $state = data_get($this->getLivewire(), $this->getStatePath());

        return [
            'latitude' => is_array($state) ? ($state['latitude'] ?? null) : null,
            'longitude' => is_array($state) ? ($state['longitude'] ?? null) : null,
        ];
    }

    /** Livewire callback, called from JavaScript */
    #[On('coords-changed')]
    public function handleCoordsChanged(array $coords): void
    {
        $stateRaw = data_get($this->getLivewire(), $this->getStatePath());
        $state = is_array($stateRaw) ? $stateRaw : [];
        $state['latitude'] = $coords['latitude'] ?? null;
        $state['longitude'] = $coords['longitude'] ?? null;
        $livewire = $this->getLivewire();
        data_set($livewire, $this->getStatePath(), $state);
    }

    /** Exposed for reverse geocoding */
    #[On('reverse-geocode')]
    public function reverseGeocode(float $latitude, float $longitude): ?string
    {
        // Simple Nominatim reverse geocode – fallback to null on error
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$latitude}&lon={$longitude}&accept-language=it";

        try {
            $response = file_get_contents($url);
        } catch (\Throwable) {
            return null;
        }
        if ('' === $response) {
            return null;
        }

        /** @var array<string, mixed>|null $data */
        $data = json_decode($response, true);

        if (! is_array($data)) {
            return null;
        }

        return is_string($data['display_name'] ?? null) ? $data['display_name'] : null;
    }

    public static function extractCoordinates(array $data, string $fieldName = 'coordinates', string $latitudeColumn = 'latitude', string $longitudeColumn = 'longitude'): array
    {
        if (! isset($data[$fieldName])) {
            return [$latitudeColumn => null, $longitudeColumn => null];
        }

        $coordinates = $data[$fieldName];
        $lat = data_get($coordinates, 'latitude');
        $lng = data_get($coordinates, 'longitude');

        // cast to float for safety
        $lat = is_numeric($lat) ? (float) $lat : null;
        $lng = is_numeric($lng) ? (float) $lng : null;

        return [$latitudeColumn => $lat, $longitudeColumn => $lng];
    }

    protected function mutateState(array $input): void
    {
        $stateRaw = data_get($this->getLivewire(), $this->getStatePath());
        $state = is_array($stateRaw) ? $stateRaw : [];
        $state['latitude'] = $input['latitude'] ?? null;
        $state['longitude'] = $input['longitude'] ?? null;
        $livewire = $this->getLivewire();
        data_set($livewire, $this->getStatePath(), $state);
    }
}
