<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Tests\Fixtures\Traits\GeographicalScopesTestModel;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * GeographicalScopes: i valori di latitudine/longitudine viaggiano come binding, mai interpolati nell'SQL.
 */
test('withDistance selects star plus the distance column with latitude and longitude bound', function (): void {
    $query = GeographicalScopesTestModel::query()->withDistance(45.5, 9.25);

    Assert::assertStringStartsWith('select *, 6371 * acos(', $query->toSql());
    Assert::assertStringContainsString('AS distance', $query->toSql());
    Assert::assertSame([45.5, 9.25, 45.5], $query->getBindings());
});

test('withDistance does not repeat star when the query already selects columns', function (): void {
    $query = GeographicalScopesTestModel::query()->select('id')->withDistance(45.5, 9.25);

    $sql = $query->toSql();

    Assert::assertMatchesRegularExpression('/^select [`"]id[`"], 6371 \* acos\(/', $sql);
    Assert::assertStringNotContainsString('select *', $sql);
});

test('orderByDistance orders by the haversine formula with the point bound', function (): void {
    $query = GeographicalScopesTestModel::query()->orderByDistance(45.5, 9.25);

    Assert::assertStringContainsString('order by 6371 * acos(', $query->toSql());
    Assert::assertSame([45.5, 9.25, 45.5], $query->getBindings());
});
