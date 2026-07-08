<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\User\Filament\Widgets\LoginWidget;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('LoginWidget', function (): void {
    test('login widget can be instantiated', function (): void {
        $widget = new LoginWidget();

        Assert::assertInstanceOf(LoginWidget::class, $widget);
    });

    test('login widget has correct form schema', function (): void {
        $widget = new LoginWidget();
        $schema = $widget->getFormSchema();

        Assert::assertCount(3, $schema);
        $emailField = $schema[0];
        Assert::assertInstanceOf(TextInput::class, $emailField);
        Assert::assertSame('email', $emailField->getName());
        Assert::assertTrue($emailField->isEmail());
        $passwordField = $schema[1];
        Assert::assertInstanceOf(TextInput::class, $passwordField);
        Assert::assertSame('password', $passwordField->getName());
        $rememberField = $schema[2];
        Assert::assertInstanceOf(Toggle::class, $rememberField);
        Assert::assertSame('remember', $rememberField->getName());
    });

    test('login widget form fill has correct defaults', function (): void {
        $widget = new LoginWidget();
        $fillData = $widget->getFormFill();

        Assert::assertArrayHasKey('email', $fillData);
        Assert::assertArrayHasKey('remember', $fillData);
        Assert::assertTrue($fillData['remember']);
    });

    test('login widget has correct view property', function (): void {
        $widget = new LoginWidget();
        $reflection = new ReflectionClass($widget);
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);
        $view = $property->getValue($widget);

        Assert::assertSame('pub_theme::filament.widgets.auth.login', $view);
    });

    test('login widget extends xot base widget', function (): void {
        $widget = new LoginWidget();

        Assert::assertInstanceOf(Modules\Xot\Filament\Widgets\XotBaseSchemaWidget::class, $widget);
    });
});
