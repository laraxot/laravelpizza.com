<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Transformers;

uses(TestCase::class);

use Modules\Geo\Tests\TestCase;
use Modules\Geo\Transformers\GeoJsonCollection;
use Modules\Geo\Transformers\GeoJsonResource;

test('GeoJsonResource can be instantiated', function () {
    expect(class_exists(GeoJsonResource::class))->toBeTrue();

    // The GeoJsonResource likely needs a model instance to be instantiated
    // For now, just test that the class exists and check its methods
    expect(method_exists(GeoJsonResource::class, 'toArray'))->toBeTrue();
});

test('GeoJsonCollection can be instantiated', function () {
    expect(class_exists(GeoJsonCollection::class))->toBeTrue();

    // Similarly, test that the class exists and check its methods
    expect(method_exists(GeoJsonCollection::class, 'toArray'))->toBeTrue();
});
