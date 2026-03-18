<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Filament\Pages;

use Modules\Cms\Filament\Pages\Themes;

test('Themes page can be instantiated', function () {
    $page = new Themes();
    expect($page)->toBeObject();
});

test('Themes page has themes property', function () {
    $page = new Themes();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('themes');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Themes page has changePubTheme method', function () {
    expect(method_exists(Themes::class, 'changePubTheme'))->toBeTrue();
});

test('Themes page has getViewData method', function () {
    expect(method_exists(Themes::class, 'getViewData'))->toBeTrue();
});
