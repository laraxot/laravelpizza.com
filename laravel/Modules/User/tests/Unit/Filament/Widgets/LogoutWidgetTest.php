<?php

declare(strict_types=1);
use Modules\User\Filament\Widgets\LogoutWidget;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('LogoutWidget', function (): void {
    test('logout widget can be instantiated', function (): void {
        new LogoutWidget;

    });

    test('logout widget extends xot base widget', function (): void {
        Assert::assertSame(XotBaseSchemaWidget::class, get_parent_class(LogoutWidget::class));

    });

    test('logout widget has is logging out flag', function (): void {
        $widget = new LogoutWidget;

        Assert::assertFalse($widget->isLoggingOut);
    });

    test('logout widget has protected get view data method', function (): void {
        $widget = new LogoutWidget;
        $reflection = new ReflectionMethod($widget, 'getViewData');

        Assert::assertTrue($reflection->isProtected());
    });
});
