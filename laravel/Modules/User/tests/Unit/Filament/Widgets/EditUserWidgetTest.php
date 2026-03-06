<?php

declare(strict_types=1);

use Modules\User\Filament\Widgets\EditUserWidget;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('EditUserWidget', function (): void {
    test('edit user widget can be instantiated', function (): void {
        $widget = new EditUserWidget();

        expect($widget)->toBeInstanceOf(EditUserWidget::class);
    });

    test('edit user widget extends xot base widget', function (): void {
        $widget = new EditUserWidget();

        expect($widget)->toBeInstanceOf(Modules\Xot\Filament\Widgets\XotBaseWidget::class);
    });

    test('edit user widget has type property', function (): void {
        $widget = new EditUserWidget();

        expect($widget)->toHaveProperty('type');
    });

    test('edit user widget has resource property', function (): void {
        $widget = new EditUserWidget();

        expect($widget)->toHaveProperty('resource');
    });

    test('edit user widget has model property', function (): void {
        $widget = new EditUserWidget();

        expect($widget)->toHaveProperty('model');
    });
});
