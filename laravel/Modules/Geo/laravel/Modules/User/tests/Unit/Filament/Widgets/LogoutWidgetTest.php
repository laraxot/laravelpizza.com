<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\LogoutWidget;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('LogoutWidget', function (): void {
    test('logout widget can be instantiated', function (): void {
        $widget = new LogoutWidget();

        Assert::assertInstanceOf(LogoutWidget::class, $widget);
    });

    test('logout widget extends xot base widget', function (): void {
        $widget = new LogoutWidget();

        Assert::assertInstanceOf(Modules\Xot\Filament\Widgets\XotBaseSchemaWidget::class, $widget);
    });

    test('logout widget has is logging out flag', function (): void {
        $widget = new LogoutWidget();

        Assert::assertFalse($widget->isLoggingOut);
    });

    test('logout widget has protected get view data method', function (): void {
        $widget = new LogoutWidget();
        $reflection = new ReflectionMethod($widget, 'getViewData');

        Assert::assertTrue($reflection->isProtected());
    });
});
