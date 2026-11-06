<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Home;
use PHPUnit\Framework\Assert;

test('Home page can be instantiated', function () {
    Assert::assertSame(Home::class, (new Home)::class);

});

test('Home page has view_type property', function () {
    $page = new Home;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    Assert::assertSame('view_type', $property->getName());
});

test('Home page has containers property', function () {
    $page = new Home;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Home page has items property', function () {
    $page = new Home;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Home page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Home page has getViewData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Home page has initView method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

// Rimosso `test('Home page has url method')`: la closure era vuota e il metodo non
// esiste. `Home` estende `XotBasePage` -> `Filament\Pages\Page`, che espone `getUrl()`
// statico, non `url()`. Riempire il test con `method_exists(Home::class, 'url')` lo
// avrebbe reso rosso; riscriverne il nome su `getUrl` sarebbe stato inventare l'intento.
