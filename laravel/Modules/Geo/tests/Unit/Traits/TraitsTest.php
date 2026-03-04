<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Traits\HandlesCoordinates;
use Modules\Geo\Traits\HasAddresses;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

test('HasAddresses trait can be used', function () {
    // Check if trait exists
    expect(trait_exists(HasAddresses::class))->toBeTrue();

    // Create an anonymous class that uses the trait
    $model = new class extends Model
    {
        use HasAddresses;

        protected $table = 'addresses';
    };

    // Check if the trait methods exist
    expect(method_exists($model, 'address') || method_exists($model, 'addresses'))->toBeTrue();
});

test('HandlesCoordinates trait can be used', function () {
    // Check if trait exists
    expect(trait_exists(HandlesCoordinates::class))->toBeTrue();

    // Create an anonymous class that uses the trait
    $model = new class extends Model
    {
        use HandlesCoordinates;

        protected $table = 'addresses';
    };

    // Check if the trait methods exist
    expect(method_exists($model, 'formatCoordinates') || method_exists($model, 'getCoordinates'))->toBeTrue();
});
