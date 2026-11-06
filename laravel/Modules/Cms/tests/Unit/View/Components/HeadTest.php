<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View\Components;

use Modules\Cms\View\Components\Head;
use PHPUnit\Framework\Assert;

test('Head is a class-based component with an optional page title', function (): void {
    $component = new Head('Pagina servizi');

    Assert::assertSame('Pagina servizi', $component->title);
});
