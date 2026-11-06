<?php

declare(strict_types=1);

use Modules\Cms\Filament\Pages\Themes;
use PHPUnit\Framework\Assert;

test('Themes page can be instantiated', function () {
    Assert::assertSame(Themes::class, (new Themes)::class);

});

test('Themes page has themes property', function () {
    $page = new Themes;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Themes page has changePubTheme method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Themes page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
