<?php

declare(strict_types=1);

use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Support\PaDesignColors;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('MetatagData puo essere istanziata', function () {
    $metatagData = new MetatagData();
    Assert::assertInstanceOf(MetatagData::class, $metatagData);
});

test('getFilamentColors restituisce i colori Filament corretti', function (): void {
    $metatagData = new MetatagData();
    $colors = $metatagData->getFilamentColors();

    Assert::assertArrayHasKey('danger', $colors);
    Assert::assertArrayHasKey('gray', $colors);
    Assert::assertArrayHasKey('info', $colors);
    Assert::assertArrayHasKey('primary', $colors);
    Assert::assertArrayHasKey('success', $colors);
    Assert::assertArrayHasKey('warning', $colors);
    Assert::assertIsString($colors['primary'][600] ?? null);
    Assert::assertEquals(PaDesignColors::filamentPalette(), $colors);
});

test('getColors gestisce correttamente i colori personalizzati', function () {
    $metatagData = new MetatagData();
    $metatagData->colors = [
        'custom_color' => [
            'key' => 'custom_color',
            'color' => 'custom',
            'hex' => '#FF5500',
        ],
        'primary' => [
            'key' => 'primary',
            'color' => 'amber',
        ],
    ];

    $colors = $metatagData->getColors();

    Assert::assertArrayHasKey('custom_color', $colors);
    Assert::assertArrayHasKey('primary', $colors);
});

test('getLogoHeight restituisce il valore corretto', function () {
    $metatagData = new MetatagData();
    $metatagData->logo_height = '3em';

    Assert::assertSame('3em', $metatagData->getLogoHeight());
});

test('Le proprieta hanno i valori di default corretti', function () {
    $metatagData = new MetatagData();

    Assert::assertSame('xot', $metatagData->generator);
    Assert::assertSame('UTF-8', $metatagData->charset);
    Assert::assertSame('xot', $metatagData->author);
    Assert::assertSame('2em', $metatagData->logo_height);
    Assert::assertSame('/favicon.ico', $metatagData->favicon);
});
