<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Actions\Maps\BuildGeoMapWidgetPayloadAction;
use Modules\Geo\Datas\Map\GeoMapWidgetData;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

test('build geo map widget payload action returns widget data contract', function () {
    $placeType = new PlaceType();
    $placeType->setAttribute('slug', 'farm');

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

    Assert::assertInstanceOf(GeoMapWidgetData::class, $payload);

    $geoJson = $payload->geoJson;
    Assert::assertArrayHasKey('type', $geoJson);
    Assert::assertSame('FeatureCollection', $geoJson['type']);
    Assert::assertArrayHasKey('features', $geoJson);
    Assert::assertIsArray($geoJson['features']);
    $features = $geoJson['features'];
    Assert::assertCount(1, $features);

    $feature = $features[0];
    Assert::assertIsArray($feature);
    Assert::assertArrayHasKey('properties', $feature);
    Assert::assertIsArray($feature['properties']);
    $properties = $feature['properties'];
    Assert::assertSame('farm', $properties['category']);
    Assert::assertSame('Cascina Demo', $properties['title']);

    Assert::assertSame(['lat' => 45.4642, 'lng' => 9.1900], $payload->initialState['center']);
    Assert::assertCount(4, $payload->layerConfig);
    Assert::assertSame(1, $payload->meta['totalFeatures']);
});
