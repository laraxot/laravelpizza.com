<?php

declare(strict_types=1);

/**
 * @see docs/metatag-population-strategy.md
 */

use Modules\Cms\Tests\TestCase;
use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('AppLayout component can be instantiated', function () {
    $component = new AppLayout;
    Assert::assertSame(AppLayout::class, $component::class);
});

test('GuestLayout component can be instantiated', function () {
    $component = new GuestLayout;
    Assert::assertSame(GuestLayout::class, $component::class);
});

test('Metatags component can be instantiated', function () {
    $component = new Metatags;
    Assert::assertSame(Metatags::class, $component::class);
});
