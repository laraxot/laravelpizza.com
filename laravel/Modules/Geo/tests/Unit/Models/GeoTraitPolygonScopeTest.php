<?php

declare(strict_types=1);

use Modules\Geo\Models\Address;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\preg_replace;

uses(LightTestCase::class);

/*
 * GeoTrait::scopeOfInPolygon(): l'SQL e' letterale e lavora su `zone_polygon`.
 * Fino al 2026-11-03 accettava qualunque colonna ma usava sempre `zone_polygon`,
 * e l'SQL aveva una parentesi chiusa in piu'.
 */

function geoPolygonParenthesisBalance(string $sql): int
{
    $withoutLiterals = preg_replace("/'[^']*'/", "''", $sql);
    Assert::assertIsString($withoutLiterals);

    return substr_count($withoutLiterals, '(') - substr_count($withoutLiterals, ')');
}

test('lo scope filtra sul poligono di zone_polygon', function (): void {
    $sql = Address::query()->ofInPolygon('zone_polygon', 45.46, 9.19)->toSql();

    Assert::assertStringContainsString('JSON_extract(zone_polygon', $sql);
    Assert::assertStringContainsString('ST_Contains(', $sql);
});

test('l SQL dello scope ha le parentesi bilanciate', function (): void {
    $sql = Address::query()->ofInPolygon('zone_polygon', 45.46, 9.19)->toSql();

    Assert::assertSame(0, geoPolygonParenthesisBalance($sql));
});

test('lo scope passa le coordinate come binding', function (): void {
    $bindings = Address::query()->ofInPolygon('zone_polygon', 45.46, 9.19)->getBindings();

    Assert::assertSame(
        [
            45.46,
            9.19,
        ],
        $bindings,
    );
});

test('lo scope rifiuta una colonna diversa da zone_polygon invece di ignorarla', function (string $column): void {
    expect(fn () => Address::query()->ofInPolygon($column, 45.46, 9.19))
        ->toThrow(InvalidArgumentException::class, 'scopeOfInPolygon supporta solo la colonna zone_polygon.');
})->with([
    'altra colonna' => ['area_polygon'],
    'non identificatore' => ['zone_polygon) OR (1=1'],
]);
