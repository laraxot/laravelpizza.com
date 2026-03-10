<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\Collection;
use Modules\UI\Tests\TestCase;

uses(TestCase::class);

describe('Collection Model', function (): void {
    test('it can create a collection with valid data', function (): void {
        $collection = Collection::factory()->create([
            'name' => 'Hero Components',
            'type' => 'block',
        ]);

        expect($collection->name)->toBe('Hero Components')
            ->and($collection->type)->toBe('block');
    });

    test('it has fillable attributes', function (): void {
        $collection = new Collection();
        $expected = ['name', 'description', 'type'];

        foreach ($expected as $field) {
            expect(in_array($field, $collection->getFillable()))->toBeTrue();
        }
    });

    test('collection has timestamps', function (): void {
        $collection = Collection::factory()->create();

        expect($collection->created_at)->not->toBeNull()
            ->and($collection->updated_at)->not->toBeNull();
    });
});
