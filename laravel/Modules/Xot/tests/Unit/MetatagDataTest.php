<?php

declare(strict_types=1);
use Modules\Xot\Actions\PaDesignColorsAction;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('MetatagData puo essere istanziata', function () {
    $metatagData = new MetatagData;

    Assert::assertSame('xot', $metatagData->generator);
});

test('getFilamentColors restituisce i colori Filament corretti', function (): void {
    $metatagData = new MetatagData;
    $colors = $metatagData->getFilamentColors();

    Assert::assertArrayHasKey('danger', $colors);
    Assert::assertArrayHasKey('gray', $colors);
    Assert::assertArrayHasKey('info', $colors);
    Assert::assertArrayHasKey('primary', $colors);
    Assert::assertArrayHasKey('success', $colors);
    Assert::assertArrayHasKey('warning', $colors);
    Assert::assertIsString($colors['primary'][600] ?? null);
    Assert::assertEquals(app(PaDesignColorsAction::class)->filamentPalette(), $colors);
});

test('getColors gestisce correttamente i colori personalizzati', function () {
    $metatagData = new MetatagData;
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

    $colors = $metatagData->colors;

    Assert::assertArrayHasKey('custom_color', $colors);
    Assert::assertArrayHasKey('primary', $colors);
});

test('getLogoHeight restituisce il valore corretto', function () {
    $metatagData = new MetatagData;
    $metatagData->logo_height = '3em';

    Assert::assertSame('3em', $metatagData->getBrandLogoHeight());
});

test('Le proprieta hanno i valori di default corretti', function () {
    $metatagData = new MetatagData;

    Assert::assertSame('xot', $metatagData->generator);
    Assert::assertSame('UTF-8', $metatagData->charset);
    Assert::assertSame('xot', $metatagData->author);
    Assert::assertSame('2em', $metatagData->logo_height);
    Assert::assertSame('/favicon.ico', $metatagData->favicon);
});

test('getBrandLogoSvg restituisce stringa vuota se il modulo principale non ha un logo.svg', function (): void {
    $xot = XotData::make();
    $original = $xot->main_module;
    $xot->main_module = 'ModuleWithoutLogoSvg';

    try {
        Assert::assertSame('', (new MetatagData)->getBrandLogoSvg());
    } finally {
        $xot->main_module = $original;
    }
});

test('getBrandLogoSvg legge il logo.svg del modulo principale quando esiste', function (): void {
    $xot = XotData::make();
    $original = $xot->main_module;
    $xot->main_module = 'Xot';

    try {
        Assert::assertStringContainsString('<svg', (new MetatagData)->getBrandLogoSvg());
    } finally {
        $xot->main_module = $original;
    }
});
