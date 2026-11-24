<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Tests\Fixtures\Traits\GeographicalScopesTestModel;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * GeoTrait distance scopes (ex GeographicalScopes): lat/lng come binding, mai interpolati.
 * Coverage dedicata anche in GeoTraitWithDistanceSqlTest (su Address).
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

test('withDistance orders calculated distances before nulls', function (): void {
    $sql = GeographicalScopesTestModel::query()->withDistance(45.5, 9.25)->toSql();

    Assert::assertStringContainsString('order by', $sql);
    Assert::assertStringContainsString('distance IS NULL', $sql);
});
