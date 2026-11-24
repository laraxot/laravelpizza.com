<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View\Components;

use Modules\Cms\Tests\TestCase;
use Modules\Cms\View\Components\Head;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

test('Head is a class-based component with an optional page title', function (): void {
    $component = new Head('Pagina servizi');

    Assert::assertSame('Pagina servizi', $component->title);
});
