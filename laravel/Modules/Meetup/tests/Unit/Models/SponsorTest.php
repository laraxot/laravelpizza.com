<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Sponsor;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

describe('Sponsor Model', function (): void {
    test('it can create a sponsor with valid data', function (): void {
        $sponsor = Sponsor::factory()->create([
            'name' => 'Laravel Italia',
            'level' => 'gold',
            'contact_email' => 'info@laravelitalia.it',
        ]);

        expect($sponsor->name)->toBe('Laravel Italia')
            ->and($sponsor->level)->toBe('gold')
            ->and($sponsor->contact_email)->toBe('info@laravelitalia.it');
    });

    test('it has fillable attributes', function (): void {
        $sponsor = new Sponsor();
        $expected = ['name', 'level', 'website', 'logo', 'description', 'contact_email', 'contact_name', 'order', 'meta_data'];

        foreach ($expected as $field) {
            expect(in_array($field, $sponsor->getFillable()))->toBeTrue();
        }
    });

    test('it casts meta_data to array', function (): void {
        $sponsor = Sponsor::factory()->create([
            'meta_data' => ['industry' => 'tech', 'employees' => 100],
        ]);

        expect($sponsor->meta_data)->toBeArray()
            ->and($sponsor->meta_data['industry'])->toBe('tech');
    });

    test('gold factory state creates gold-level sponsor', function (): void {
        $sponsor = Sponsor::factory()->gold()->create();

        expect($sponsor->level)->toBe('gold');
    });

    test('platinum factory state creates platinum-level sponsor', function (): void {
        $sponsor = Sponsor::factory()->platinum()->create();

        expect($sponsor->level)->toBe('platinum');
    });

    test('community factory state creates community-level sponsor', function (): void {
        $sponsor = Sponsor::factory()->community()->create();

        expect($sponsor->level)->toBe('community');
    });

    test('sponsor belongs to many events', function (): void {
        $sponsor = Sponsor::factory()->create();
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();

        $sponsor->events()->attach($event1);
        $sponsor->events()->attach($event2);

        expect($sponsor->events)->toHaveCount(2);
    });

    test('sponsor can have contact name and email', function (): void {
        $sponsor = Sponsor::factory()->create([
            'contact_name' => 'Mario Rossi',
            'contact_email' => 'mario@esempio.it',
        ]);

        expect($sponsor->contact_name)->toBe('Mario Rossi')
            ->and($sponsor->contact_email)->toBe('mario@esempio.it');
    });

    test('sponsor has timestamps', function (): void {
        $sponsor = Sponsor::factory()->create();

        expect($sponsor->created_at)->not->toBeNull()
            ->and($sponsor->updated_at)->not->toBeNull();
    });
});
