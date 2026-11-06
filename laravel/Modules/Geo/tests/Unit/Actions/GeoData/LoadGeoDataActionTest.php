<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GeoData;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Modules\Geo\Actions\GeoData\LoadGeoDataAction;
use Modules\Geo\Infrastructure\Config\GeoDataConfig;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;
use Safe\Exceptions\JsonException;

use function Safe\json_encode;

uses(LightTestCase::class);

/**
 * Regione valida per le regole di GeoDataValidationRules: codice regione e sigla provincia a 2 caratteri, CAP a 5.
 *
 * @return array<string, mixed>
 */
function geoRegionFixture(string $name, string $code): array
{
    return [
        'name' => $name,
        'code' => $code,
        'provinces' => [
            [
                'name' => 'Milano',
                'code' => 'MI',
                'cities' => [
                    ['name' => 'Milano', 'code' => 'F205', 'cap' => '20100'],
                ],
            ],
        ],
    ];
}

/**
 * Fa leggere all'action il contenuto dato al posto di Modules/Geo/resources/json/comuni.json.
 */
function geoJsonFileContains(string $contents): void
{
    $path = base_path(GeoDataConfig::JSON_PATH);

    File::shouldReceive('exists')->once()->with($path)->andReturnTrue();
    File::shouldReceive('get')->once()->with($path)->andReturn($contents);
}

test('LoadGeoDataAction returns the regions of the JSON file as a re-indexed collection', function (): void {
    geoJsonFileContains(json_encode([
        'regions' => [geoRegionFixture('Lombardia', '03'), geoRegionFixture('Lazio', '12')],
    ]));

    $regions = app(LoadGeoDataAction::class)->execute();

    Assert::assertInstanceOf(Collection::class, $regions);
    Assert::assertSame(['Lombardia', 'Lazio'], $regions->pluck('name')->all());
    Assert::assertSame([0, 1], $regions->keys()->all());
});

test('LoadGeoDataAction keeps the region to province to city hierarchy intact', function (): void {
    geoJsonFileContains(json_encode(['regions' => [geoRegionFixture('Lombardia', '03')]]));

    $region = app(LoadGeoDataAction::class)->execute()->firstOrFail();

    Assert::assertSame([
        [
            'name' => 'Milano',
            'code' => 'MI',
            'cities' => [['name' => 'Milano', 'code' => 'F205', 'cap' => '20100']],
        ],
    ], $region['provinces']);
});

test('LoadGeoDataAction throws when the JSON file is missing and never reads it', function (): void {
    File::shouldReceive('exists')->once()->with(base_path(GeoDataConfig::JSON_PATH))->andReturnFalse();
    File::shouldReceive('get')->never();

    expect(fn (): Collection => app(LoadGeoDataAction::class)->execute())
        ->toThrow(\RuntimeException::class, 'Il file JSON dei comuni non esiste');
});

test('LoadGeoDataAction does not swallow a JSON syntax error', function (): void {
    geoJsonFileContains('invalid json');

    expect(fn (): Collection => app(LoadGeoDataAction::class)->execute())
        ->toThrow(JsonException::class);
});

test('LoadGeoDataAction rejects a document that is not a valid geo hierarchy', function (string $contents): void {
    geoJsonFileContains($contents);

    expect(fn (): Collection => app(LoadGeoDataAction::class)->execute())
        ->toThrow(\RuntimeException::class, 'Il file JSON dei comuni non è valido');
})->with([
    'valore scalare' => ['123'],
    'senza chiave regions' => [json_encode(['provinces' => []])],
    'regions non e un array' => [json_encode(['regions' => 'not-array'])],
    'regione senza province' => [json_encode(['regions' => [['name' => 'Lombardia', 'code' => '03', 'provinces' => []]]])],
    'comune senza CAP' => [json_encode(['regions' => [[
        'name' => 'Lombardia',
        'code' => '03',
        'provinces' => [['name' => 'Milano', 'code' => 'MI', 'cities' => [['name' => 'Milano', 'code' => 'F205']]]],
    ]]])],
    'codice regione duplicato' => [json_encode([
        'regions' => [geoRegionFixture('Lombardia', '03'), geoRegionFixture('Lazio', '03')],
    ])],
]);
