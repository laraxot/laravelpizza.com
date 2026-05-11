<?php

declare(strict_types=1);

uses(LightTestCase::class);

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Actions\Maps\BuildGeoMapWidgetPayloadAction;
use Modules\Geo\Datas\Map\GeoMapWidgetData;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Tests\LightTestCase;

test('build geo map widget payload action returns widget data contract', function () {
    $placeType = new PlaceType();
    $placeType->slug = 'farm';

    $place = new Place();
    $place->id = 42;
    $place->name = 'Cascina Demo';
    $place->description = 'Vendita diretta';
    $place->latitude = 45.4642;
    $place->longitude = 9.1900;
    $place->setRelation('placeType', $placeType);
    $place->formatted_address = 'Via Roma 1, Milano';

    $action = new class(new Collection([$place])) extends BuildGeoMapWidgetPayloadAction {
        /**
         * @param Collection<int, Place> $places
         */
        public function __construct(private readonly Collection $places)
        {
        }

        /**
         * @return Collection<int, Place>
         */
        protected function getPlaces(): Collection
        {
            return $this->places;
        }
    };

    $payload = $action->execute();

    expect($payload)->toBeInstanceOf(GeoMapWidgetData::class)
        ->and($payload->geoJson)->toHaveKey('type')
        ->and($payload->geoJson['type'])->toBe('FeatureCollection')
        ->and($payload->geoJson)->toHaveKey('features')
        ->and($payload->geoJson['features'])->toHaveCount(1)
        ->and($payload->geoJson['features'][0]['properties']['category'])->toBe('farm')
        ->and($payload->geoJson['features'][0]['properties']['title'])->toBe('Cascina Demo')
        ->and($payload->initialState)->toHaveKeys(['center', 'zoom', 'selectedId', 'activeLayers', 'filters'])
        ->and($payload->initialState['center'])->toBe(['lat' => 45.4642, 'lng' => 9.1900])
        ->and($payload->layerConfig)->toHaveCount(4)
        ->and($payload->meta['totalFeatures'])->toBe(1);
});
