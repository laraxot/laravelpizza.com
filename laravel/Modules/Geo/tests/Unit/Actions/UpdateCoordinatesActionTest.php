<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\GetCoordinatesAction;
use Modules\Geo\Actions\UpdateCoordinatesAction;
use Modules\Geo\Models\Place;

beforeEach(function () {
    // Set up Google Maps API key for tests
    Config::set('services.google.maps.key', 'test-api-key');

    // Mock HTTP responses
    Http::fake([
        'maps.googleapis.com/*' => Http::response([
            'status' => 'OK',
            'results' => [
                [
                    'geometry' => [
                        'location' => [
                            'lat' => 45.4642,
                            'lng' => 9.1900,
                        ],
                    ],
                ],
            ],
        ], 200),
    ]);

    $this->getCoordinatesAction = new GetCoordinatesAction();
    $this->action = new UpdateCoordinatesAction($this->getCoordinatesAction);
});

it('updates coordinates for a place with valid address', function (): void {
    // Create a place without using the factory to avoid PlaceType dependency
    $place = new Place([
        'latitude' => null,
        'longitude' => null,
        'formatted_address' => 'Via Roma 123, Milano, Italia',
    ]);
    $place->save();  // Save to get an ID

    // Create an address with formatted_address
    $address = new Modules\Geo\Models\Address([
        'formatted_address' => 'Via Roma 123, Milano, Italia',
        'street' => 'Via Roma 123',
        'city' => 'Milano',
        'country' => 'Italia',
        'place_id' => $place->id,
    ]);
    $address->save();

    // Link the address to the place
    $place->address()->associate($address);
    $place->save();

    // Execute the action
    $this->action->execute($place);

    // Refresh the place to get updated values
    $place->refresh();

    // Assert coordinates were updated
    expect($place->latitude)->toBe(45.4642);
    expect($place->longitude)->toBe(9.1900);
});

it('throws exception when place has no address', function (): void {
    // Create a place without address
    $place = new Place([
        'latitude' => null,
        'longitude' => null,
    ]);
    $place->save(); // Save to get an ID

    // Execute the action and expect exception
    expect(fn () => $this->action->execute($place))->toThrow(RuntimeException::class, 'Place address is required');
});

it('throws exception when coordinates cannot be retrieved', function (): void {
    // Create a place with address
    $place = new Place([
        'latitude' => null,
        'longitude' => null,
        'formatted_address' => 'Invalid Address That Does Not Exist',
    ]);
    $place->save(); // Save to get an ID

    // Create an address with formatted_address
    $address = new Modules\Geo\Models\Address([
        'formatted_address' => 'Invalid Address That Does Not Exist',
        'street' => 'Invalid',
        'city' => 'Invalid',
        'country' => 'Invalid',
        'place_id' => $place->id,
    ]);
    $address->save();

    // Link the address to the place
    $place->address()->associate($address);
    $place->save();

    // Mock the response to return no results
    Http::fake([
        'maps.googleapis.com/*' => Http::response([
            'status' => 'ZERO_RESULTS',
            'results' => [],
        ], 200),
    ]);

    // Execute the action and expect exception
    expect(fn () => $this->action->execute($place))->toThrow(RuntimeException::class, 'Could not get coordinates for address: Invalid Address That Does Not Exist');
});

it('handles null address formatted_address', function (): void {
    // Create a place with address that has null formatted_address
    $place = new Place([
        'latitude' => null,
        'longitude' => null,
    ]);
    $place->save(); // Save to get an ID

    // Create an address with null formatted address
    $address = new Modules\Geo\Models\Address([
        'formatted_address' => null,
        'street' => 'Via Roma 123',
        'city' => 'Milano',
        'country' => 'Italia',
        'place_id' => $place->id,
    ]);
    $address->save();

    // Link the address to the place
    $place->address()->associate($address);
    $place->save();

    // Execute the action and expect exception
    expect(fn () => $this->action->execute($place))->toThrow(RuntimeException::class, 'Place address is required');
});

it('updates coordinates with different address', function (): void {
    // Create a place with address
    $place = new Place([
        'latitude' => null,
        'longitude' => null,
        'formatted_address' => 'Piazza del Duomo, Milano, Italia',
    ]);
    $place->save(); // Save to get an ID

    // Create an address with formatted_address
    $address = new Modules\Geo\Models\Address([
        'formatted_address' => 'Piazza del Duomo, Milano, Italia',
        'street' => 'Piazza del Duomo',
        'city' => 'Milano',
        'country' => 'Italia',
        'place_id' => $place->id,
    ]);
    $address->save();

    // Link the address to the place
    $place->address()->associate($address);
    $place->save();

    // Mock different coordinates for this address
    Http::fake([
        'maps.googleapis.com/*' => Http::response([
            'status' => 'OK',
            'results' => [
                [
                    'geometry' => [
                        'location' => [
                            'lat' => 45.4641,
                            'lng' => 9.1912,
                        ],
                    ],
                ],
            ],
        ], 200),
    ]);

    // Execute the action
    $this->action->execute($place);

    // Refresh the place to get updated values
    $place->refresh();

    // Assert coordinates were updated to new values
    expect($place->latitude)->toBe(45.4641);
    expect($place->longitude)->toBe(9.1912);
});
