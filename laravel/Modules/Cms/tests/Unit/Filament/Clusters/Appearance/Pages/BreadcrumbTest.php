<?php

declare(strict_types=1);

use Modules\Cms\Filament\Clusters\Appearance\Pages\Breadcrumb;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('Breadcrumb page uses correct view', function () {
    $page = new Breadcrumb;
    // Access protected property via reflection
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    Assert::assertSame('cms::filament.clusters.appearance.pages.headernav', $property->getValue($page));
});

test('Breadcrumb page can be instantiated', function () {
    Assert::assertSame(Breadcrumb::class, (new Breadcrumb)::class);

});

test('Breadcrumb page has data property', function () {
    $page = new Breadcrumb;
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Breadcrumb page has mount method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Breadcrumb page has schema method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');

test('Breadcrumb page has updateData method', function () {})->todo('Serve una asserzione di comportamento: method_exists() su una classe nota e\' decidibile staticamente, quindi non prova niente.');
