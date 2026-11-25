<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Tests\TestCase;
use Modules\Rating\View\Components\Dashboard\Item;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Item è un componente Blade che non renderizza nulla', function (): void {
    // Contratto reale: `render()` ritorna la stringa vuota. Il componente è registrato ma
    // non ha ancora una view — segnalato in docs/testing-and-coverage.md.
    $item = new Item;

    Assert::assertSame('', $item->render());
});
