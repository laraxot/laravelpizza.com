<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Filament\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('LoginWidget', function (): void {
    test('login widget can be instantiated', function (): void {
        $widget = new LoginWidget();

        expect($widget)->toBeInstanceOf(LoginWidget::class);
    });

    test('login widget has correct form schema', function (): void {
        $widget = new LoginWidget();
        $schema = $widget->getFormSchema();

        expect($schema)->toHaveCount(3);

        $emailField = $schema[0];
        expect($emailField)->toBeInstanceOf(TextInput::class);
        expect($emailField->getName())->toBe('email');
        expect($emailField->isEmail())->toBeTrue();

        $passwordField = $schema[1];
        expect($passwordField)->toBeInstanceOf(TextInput::class);
        expect($passwordField->getName())->toBe('password');

        $rememberField = $schema[2];
        expect($rememberField)->toBeInstanceOf(Toggle::class);
        expect($rememberField->getName())->toBe('remember');
    });

    test('login widget form fill has correct defaults', function (): void {
        $widget = new LoginWidget();
        $fillData = $widget->getFormFill();

        expect($fillData)->toHaveKey('email');
        expect($fillData)->toHaveKey('remember');
        expect($fillData['remember'])->toBeTrue();
    });

    test('login widget has correct view property', function (): void {
        $widget = new LoginWidget();
        $reflection = new ReflectionClass($widget);
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);
        $view = $property->getValue($widget);

        expect($view)->toBe('pub_theme::filament.widgets.auth.login');
    });

    test('login widget extends xot base widget', function (): void {
        $widget = new LoginWidget();

        expect($widget)->toBeInstanceOf(Modules\Xot\Filament\Widgets\XotBaseWidget::class);
    });
});
