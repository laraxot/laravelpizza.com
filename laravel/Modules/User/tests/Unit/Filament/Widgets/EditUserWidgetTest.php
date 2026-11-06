<?php

declare(strict_types=1);
use Modules\User\Filament\Widgets\EditUserWidget;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('EditUserWidget', function (): void {
    test('edit user widget can be instantiated', function (): void {
        new EditUserWidget;

    });

    test('edit user widget extends xot base widget', function (): void {
        Assert::assertSame(XotBaseSchemaWidget::class, get_parent_class(EditUserWidget::class));

    });

    test('edit user widget has type property', function (): void {
        $widget = new EditUserWidget;

        Assert::assertObjectHasProperty('type', $widget);
    });

    test('edit user widget has resource property', function (): void {
        $widget = new EditUserWidget;

        Assert::assertObjectHasProperty('resource', $widget);
    });

    test('edit user widget has model property', function (): void {
        $widget = new EditUserWidget;

        Assert::assertObjectHasProperty('model', $widget);
    });
});
