<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

uses(TestCase::class, WithFaker::class);

beforeEach(function () {
    Http::fake();
});

afterEach(function () {
    Http::assertNothingSent();
});

describe('Geo API Endpoints', function () {
    it('GET /api/geo/geocode returns geocoded address', function () {
        Http::fake([
            'nominatim.openstreetmap.org/search*' => Http::response([
                [
                    'place_id' => 123,
                    'display_name' => 'Via Roma 1, 20100 Milano MI, Italia',
                    'lat' => '45.4642',
                    'lon' => '9.1900',
                    'address' => ['city' => 'Milano', 'country' => 'Italia'],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/geo/geocode?address=Via Roma 1, Milano');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'formatted_address',
                    'coordinates' => ['latitude', 'longitude'],
                ],
            ]);
    });

    it('GET /api/geo/reverse returns address for coordinates', function () {
        Http::fake([
            'nominatim.openstreetmap.org/reverse*' => Http::response([
                'display_name' => 'Piazza del Duomo, 20121 Milano, Italia',
                'address' => ['city' => 'Milano'],
            ], 200),
        ]);

        $response = $this->getJson('/api/geo/reverse?lat=45.4642&lng=9.1900');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'display_name',
                    'address',
                ],
            ]);
    });

    it('GET /api/geo/suggestions returns autocomplete suggestions', function () {
        Http::fake([
            'nominatim.openstreetmap.org/search*' => Http::response([
                ['display_name' => 'Via Roma, Milano', 'lat' => '45.4642', 'lon' => '9.1900'],
                ['display_name' => 'Via Roma, Roma', 'lat' => '41.9028', 'lon' => '12.4964'],
            ], 200),
        ]);

        $response = $this->getJson('/api/geo/suggestions?q=Via Roma');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['display_name', 'coordinates'],
                ],
            ]);
    });

    it('POST /api/geo/distance calculates distance between points', function () {
        Http::fake([
            'maps.googleapis.com/maps/api/distancematrix/json*' => Http::response([
                'rows' => [[
                    'elements' => [[
                        'distance' => ['value' => 570000, 'text' => '570 km'],
                        'duration' => ['value' => 19800, 'text' => '5h 30m'],
                        'status' => 'OK',
                    ]],
                ]],
                'status' => 'OK',
            ], 200),
        ]);

        $response = $this->postJson('/api/geo/distance', [
            'origins' => ['Milano, Italia'],
            'destinations' => ['Roma, Italia'],
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'distance',
                    'duration',
                    'formatted_distance',
                    'formatted_duration',
                ],
            ]);
    });

    it('POST /api/geo/elevation returns elevation for coordinates', function () {
        Http::fake([
            'api.open-elevation.com/api/v1/lookup*' => Http::response([
                'results' => [
                    ['latitude' => 45.4642, 'longitude' => 9.1900, 'elevation' => 122.5],
                ],
            ], 200),
        ]);

        $response = $this->postJson('/api/geo/elevation', [
            'coordinates' => [['lat' => 45.4642, 'lng' => 9.1900]],
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['latitude', 'longitude', 'elevation'],
                ],
            ]);
    });

    it('returns 422 for invalid geocode request', function () {
        $response = $this->getJson('/api/geo/geocode');

        $response->assertUnprocessable();
    });

    it('returns 422 for invalid reverse geocode request', function () {
        $response = $this->getJson('/api/geo/reverse');

        $response->assertUnprocessable();
    });
});
