<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Venue;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('Venue Model', function (): void {
    test('it can create a venue with valid data', function (): void {
        $venue = Venue::factory()->create([
            'name' => 'Milano Tech Hub',
            'city' => 'Milano',
            'capacity' => 200,
        ]);

        expect($venue->name)->toBe('Milano Tech Hub')
            ->and($venue->city)->toBe('Milano')
            ->and($venue->capacity)->toBe(200);
    });

    test('it has fillable attributes', function (): void {
        $venue = new Venue();
        $expected = ['name', 'address', 'city', 'country', 'latitude', 'longitude', 'capacity', 'website', 'phone', 'description', 'meta_data'];

        foreach ($expected as $field) {
            expect(in_array($field, $venue->getFillable()))->toBeTrue();
        }
    });

    test('it casts latitude and longitude to float', function (): void {
        $venue = Venue::factory()->create([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);

        expect($venue->latitude)->toBeFloat()
            ->and($venue->longitude)->toBeFloat()
            ->and($venue->latitude)->toBe(45.4642)
            ->and($venue->longitude)->toBe(9.1900);
    });

    test('it casts capacity to integer', function (): void {
        $venue = Venue::factory()->create(['capacity' => '150']);

        expect($venue->capacity)->toBeInt()
            ->and($venue->capacity)->toBe(150);
    });

    test('it casts meta_data to array', function (): void {
        $venue = Venue::factory()->create([
            'meta_data' => ['wifi' => true, 'parking' => false],
        ]);

        expect($venue->meta_data)->toBeArray()
            ->and($venue->meta_data['wifi'])->toBeTrue();
    });

    test('large factory state creates venue with high capacity', function (): void {
        $venue = Venue::factory()->large()->create();

        expect($venue->capacity)->toBeGreaterThanOrEqual(200);
    });

    test('small factory state creates venue with low capacity', function (): void {
        $venue = Venue::factory()->small()->create();

        expect($venue->capacity)->toBeLessThanOrEqual(50);
    });

    test('venue has many events relationship', function (): void {
        $venue = Venue::factory()->create();
        $event1 = Event::factory()->withVenue($venue)->create();
        $event2 = Event::factory()->withVenue($venue)->create();

        expect($venue->events)->toHaveCount(2);
    });

    test('venue can have null optional fields', function (): void {
        $venue = Venue::factory()->create([
            'address' => null,
            'website' => null,
            'phone' => null,
            'description' => null,
        ]);

        expect($venue->address)->toBeNull()
            ->and($venue->website)->toBeNull()
            ->and($venue->phone)->toBeNull()
            ->and($venue->description)->toBeNull();
    });

    test('venue has timestamps', function (): void {
        $venue = Venue::factory()->create();

        expect($venue->created_at)->not->toBeNull()
            ->and($venue->updated_at)->not->toBeNull();
    });
});
