<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\Performer;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

describe('Performer Model', function (): void {
    test('it can create a performer with valid data', function (): void {
        $performer = Performer::factory()->create([
            'name' => 'John Doe',
            'type' => 'speaker',
            'bio' => 'Experienced PHP developer',
        ]);

        expect($performer->name)->toBe('John Doe')
            ->and($performer->type)->toBe('speaker')
            ->and($performer->bio)->toBe('Experienced PHP developer');
    });

    test('it has fillable attributes', function (): void {
        $performer = new Performer();
        $expected = ['name', 'type', 'bio', 'photo', 'website', 'email', 'company', 'twitter', 'linkedin', 'github', 'meta_data'];

        foreach ($expected as $field) {
            expect(in_array($field, $performer->getFillable()))->toBeTrue();
        }
    });

    test('it casts meta_data to array', function (): void {
        $performer = Performer::factory()->create([
            'meta_data' => ['key' => 'value', 'foo' => 'bar'],
        ]);

        expect($performer->meta_data)->toBeArray()
            ->and($performer->meta_data['key'])->toBe('value');
    });

    test('byType scope filters performers correctly', function (): void {
        $speaker = Performer::factory()->create(['type' => 'speaker']);
        $host = Performer::factory()->create(['type' => 'host']);
        $moderator = Performer::factory()->create(['type' => 'moderator']);

        $speakers = Performer::byType('speaker')->get();

        expect($speakers->contains($speaker))->toBeTrue()
            ->and($speakers->contains($host))->toBeFalse()
            ->and($speakers->contains($moderator))->toBeFalse();
    });

    test('it stores social media handles', function (): void {
        $performer = Performer::factory()->create([
            'twitter' => '@johndoe',
            'linkedin' => 'john-doe',
            'github' => 'johndoe',
        ]);

        expect($performer->twitter)->toBe('@johndoe')
            ->and($performer->linkedin)->toBe('john-doe')
            ->and($performer->github)->toBe('johndoe');
    });

    test('it stores company and website info', function (): void {
        $performer = Performer::factory()->create([
            'company' => 'Acme Corp',
            'website' => 'https://johndoe.com',
        ]);

        expect($performer->company)->toBe('Acme Corp')
            ->and($performer->website)->toBe('https://johndoe.com');
    });

    test('it can store photo path', function (): void {
        $performer = Performer::factory()->create([
            'photo' => '/photos/speaker.jpg',
        ]);

        expect($performer->photo)->toBe('/photos/speaker.jpg');
    });

    test('byType scope returns empty collection for non-existent type', function (): void {
        Performer::factory()->create(['type' => 'speaker']);
        Performer::factory()->create(['type' => 'host']);

        $organizers = Performer::byType('organizer')->get();

        expect($organizers->count())->toBe(0);
    });

    test('performer can be created from factory', function (): void {
        $performer = Performer::factory()->create();

        expect($performer->id)->not->toBeNull()
            ->and($performer->name)->not->toBeEmpty();
    });

    test('performer email is unique when factory creates it', function (): void {
        $performer1 = Performer::factory()->create();
        $performer2 = Performer::factory()->create();

        expect($performer1->email)->not->toBe($performer2->email);
    });

    test('performer meta_data defaults to array', function (): void {
        $performer = Performer::factory()->create();

        expect($performer->meta_data)->toBeArray();
    });

    test('performer has timestamps', function (): void {
        $performer = Performer::factory()->create();

        expect($performer->created_at)->not->toBeNull()
            ->and($performer->updated_at)->not->toBeNull();
    });
});

