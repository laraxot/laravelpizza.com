<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament\Widgets;

use Modules\UI\Filament\Widgets\RowWidget;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('row widget returns empty form schema', function (): void {
    $widget = new class extends RowWidget {};
    Assert::assertSame([], $widget->getFormSchema());
});

test('row widget exposes grid and widgets arrays', function (): void {
    $widget = new class extends RowWidget {};
    Assert::assertSame([], $widget->grid);
    Assert::assertSame([], $widget->widgets);
});
