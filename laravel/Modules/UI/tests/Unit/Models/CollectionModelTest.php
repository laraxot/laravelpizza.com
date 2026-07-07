<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Database\Factories\CollectionFactory;
use Modules\UI\Models\Collection;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Collection Model', function (): void {
    test('it can create a collection with valid data', function (): void {
        $collection = CollectionFactory::new()->createOne([
            'name' => 'Hero Components',
            'type' => 'block',
            'theme_id' => 1,
        ]);

        Assert::assertSame('block', $collection->type);
        Assert::assertSame('Hero Components', $collection->name);
    });

    test('it has fillable attributes', function (): void {
        $collection = new Collection();
        $collection = new Collection();
        $expected = ['name', 'description', 'type'];

        foreach ($expected as $field) {
            Assert::assertTrue(in_array($field, $collection->getFillable()));
        }
    });

    test('collection has timestamps', function (): void {
        $collection = CollectionFactory::new()->createOne();

        Assert::assertNotNull($collection->created_at);
        Assert::assertNotNull($collection->updated_at);
    });
});
