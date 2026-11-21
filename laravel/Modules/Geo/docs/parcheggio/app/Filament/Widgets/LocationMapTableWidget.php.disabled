<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Cheesegrits\FilamentGoogleMaps\Actions\GoToAction;
use Cheesegrits\FilamentGoogleMaps\Actions\RadiusAction;
use Cheesegrits\FilamentGoogleMaps\Filters\MapIsFilter;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Cheesegrits\FilamentGoogleMaps\Widgets\MapTableWidget;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Models\Location;
use Modules\Geo\Models\Place;

class LocationMapTableWidget extends MapTableWidget
{
    protected static null|string $heading = 'Location Map';

    protected static null|int $sort = 1;

    protected static null|string $pollingInterval = null;

    protected static null|bool $clustering = true;

    protected static null|bool $fitToBounds = true;

    protected static null|string $mapId = 'incidents';

    protected static null|bool $filtered = true;

    protected static bool $collapsible = true;

    public null|bool $mapIsFilter = false;

    protected static null|string $markerAction = 'markerAction';

    public function getConfig(): array
    {
        $config = parent::getConfig();

        // Disable points of interest
        //        $config['mapConfig']['styles'] = [
        //            [
        //                'featureType' => 'poi',
        //                'elementType' => 'labels',
        //                'stylers' => [
        //                    ['visibility' => 'off'],
        //                ],
        //            ],
        //        ];

        //        $config['zoom'] = 5;
        $config['center'] = [
            'lat' => 34.730369,
            'lng' => -86.586104,
        ];

        return $config;
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make()->schema([
                TextInput::make('name')->maxLength(256),
                TextInput::make('lat')->maxLength(32),
                TextInput::make('lng')->maxLength(32),
                TextInput::make('street')->maxLength(255),
                TextInput::make('city')->maxLength(255),
                TextInput::make('state')->maxLength(255),
                TextInput::make('zip')->maxLength(255),
                TextInput::make('formatted_address')->maxLength(1024),
            ]),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Location::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable(),
            TextColumn::make('street')->searchable(),
            TextColumn::make('city')->searchable()->sortable(),
            TextColumn::make('state')->searchable()->sortable(),
            TextColumn::make('zip'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            RadiusFilter::make('location')->section('Radius Filter')->selectUnit(),
            MapIsFilter::make('map'),
        ];
    }

    protected function getTableRecordAction(): null|string
    {
        return 'edit';
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()->form($this->getFormSchema()),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make()->form($this->getFormSchema()),
            Tables\Actions\EditAction::make()->form($this->getFormSchema()),
            GoToAction::make()->zoom(fn() => 14),
            RadiusAction::make('location'),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    /**
     * @return array<int, array{location: array{lat: float, lng: float}, label: string, id: int, icon: array{url: string, type: string, scale: array<int, int>}}>
     */
    public function getData(): array
    {
        $locations = $this->getRecords();
        $data = [];

        foreach ($locations as $location) {
            if ($location->latitude && $location->longitude) {
                $iconUrl = $this->getMarkerIcon($location);

                $data[] = [
                    'location' => [
                        'lat' => (float) $location->latitude,
                        'lng' => (float) $location->longitude,
                    ],
                    'label' => (string) $location->name,
                    'id' => (int) $location->id,
                    'icon' => [
                        'url' => is_string($iconUrl) ? $iconUrl : '',
                        'type' => 'url',
                        'scale' => [32, 32],
                    ],
                ];
            }
        }

        return $data;
    }

    public function markerAction(): Action
    {
        return Action::make('markerAction')
            ->label('Details')
            ->infolist([
                Section::make([
                    TextEntry::make('name'),
                    TextEntry::make('street'),
                    TextEntry::make('city'),
                    TextEntry::make('state'),
                    TextEntry::make('zip'),
                    TextEntry::make('formatted_address'),
                ])->columns(3),
            ])
            ->record(fn (array $arguments) => array_key_exists('model_id', $arguments) ? Location::find($arguments['model_id']) : null)
            ->modalSubmitAction(false);
    }

    /**
     * @return string|null
     */
    public function getMarkerIcon(Place $place): null|string
    {
        $type = $place->placeType->slug ?? 'default';
        /** @var array<string, mixed>|null $markerConfig */
        $markerConfig = config("geo.markers.types.{$type}");

        if (!is_array($markerConfig)) {
            /** @var array<string, mixed>|null $defaultConfig */
            $defaultConfig = config('geo.markers.types.default');
            $markerConfig = $defaultConfig;
        }

        if (!is_array($markerConfig)) {
            return null;
        }

        // Validazione sicura per accesso nested all'icona
        /** @var mixed $iconConfig */
        $iconConfig = $markerConfig['icon'] ?? null;

        if (!is_array($iconConfig)) {
            return null;
        }

        /** @var string|null $iconUrl */
        $iconUrl = $iconConfig['url'] ?? null;

        return is_string($iconUrl) ? $iconUrl : null;
    }
}
