<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Region;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Sushi\Sushi;

uses(TestCase::class);

/**
 * Contratto di dominio Region (Sushi da comuni.json, chiave intera, schema colonne).
 * Assert PHPUnit: evita crash pest-plugin-phpstan HigherOrderExpectationTypeExtension.
 */
describe('Region Business Logic', function () {
    test('region extends base model', function () {
        Assert::assertSame(BaseModel::class, get_parent_class(Region::class));
    });

    test('region has factory trait for testing', function () {
        Assert::assertContains(HasFactory::class, class_uses_recursive(Region::class));
    });

    test('region uses sushi trait for in-memory data', function () {
        Assert::assertContains(Sushi::class, class_uses_recursive(Region::class));
    });

    test('region has correct key type configured', function () {
        Assert::assertSame('integer', (new Region)->getKeyType());
    });

    test('region has schema definition for geographic data', function () {
        $schema = (new Region)->getSchema();

        Assert::assertIsArray($schema);
        Assert::assertSame('integer', $schema['id'] ?? null);
        Assert::assertSame('string', $schema['name'] ?? null);
    });

    test('region factory produces region instance', function () {})->todo();

    test('region model can be instantiated without errors', function () {
        $region = new Region;

        Assert::assertFalse($region->exists);
    });

    test('region can be queried by name', function () {
        Assert::assertInstanceOf(Builder::class, Region::whereName('Lombardia'));
    });

    test('region can be queried by id', function () {
        Assert::assertInstanceOf(Builder::class, Region::whereId(1));
    });
});
