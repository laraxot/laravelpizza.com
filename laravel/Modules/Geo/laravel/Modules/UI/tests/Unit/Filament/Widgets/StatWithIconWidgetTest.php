<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\UI\Filament\Widgets\StatWithIconWidget;
use Modules\UI\Tests\TestCase;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('stat with icon widget extends filament widget', function (): void {
    $widget = new StatWithIconWidget();
    Assert::assertInstanceOf(Widget::class, $widget);
    Assert::assertInstanceOf(XotBaseSchemaWidget::class, $widget);
});

test('stat with icon widget can be instantiated', function (): void {
    $widget = new StatWithIconWidget();
    Assert::assertInstanceOf(StatWithIconWidget::class, $widget);
});

test('stat with icon widget returns empty form schema', function (): void {
    $widget = new StatWithIconWidget();
    Assert::assertSame([], $widget->getFormSchema());
});
