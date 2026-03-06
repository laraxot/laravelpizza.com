<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\LogoutWidget;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('LogoutWidget', function (): void {
    test('logout widget can be instantiated', function (): void {
        $widget = new LogoutWidget();

        expect($widget)->toBeInstanceOf(LogoutWidget::class);
    });

    test('logout widget extends xot base widget', function (): void {
        $widget = new LogoutWidget();

        expect($widget)->toBeInstanceOf(Modules\Xot\Filament\Widgets\XotBaseWidget::class);
    });

    test('logout widget has is logging out flag', function (): void {
        $widget = new LogoutWidget();

        expect($widget->isLoggingOut)->toBeFalse();
    });

    test('logout widget has protected get view data method', function (): void {
        $widget = new LogoutWidget();
        $reflection = new ReflectionMethod($widget, 'getViewData');

        expect($reflection->isProtected())->toBeTrue();
    });
});
