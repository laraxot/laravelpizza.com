<?php

declare(strict_types=1);
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Modules\User\Filament\Resources\UserResource\Schemas\UserForm;
use Modules\User\Filament\Widgets\Auth\BaseAuthWidget;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

uses(TestCase::class);

describe('LoginWidget', function (): void {
    test('login widget can be instantiated', function (): void {
        new LoginWidget;

    });

    test('login widget has correct form schema', function (): void {
        // Lo schema non vive piu' nel widget: LoginWidget delega a UserForm::getLoginFormSchema()
        // (formClass()/schemaMethod() di XotBaseSchemaWidget), chiavi = nomi dei campi.
        $schema = UserForm::getLoginFormSchema();

        Assert::assertSame(['email', 'password', 'remember'], array_keys($schema));
        $emailField = $schema['email'];
        Assert::assertInstanceOf(TextInput::class, $emailField);
        Assert::assertSame('email', $emailField->getName());
        Assert::assertTrue($emailField->isEmail());
        $passwordField = $schema['password'];
        Assert::assertInstanceOf(TextInput::class, $passwordField);
        Assert::assertSame('password', $passwordField->getName());
        $rememberField = $schema['remember'];
        Assert::assertInstanceOf(Checkbox::class, $rememberField);
        Assert::assertSame('remember', $rememberField->getName());
    });

    test('login widget form fill has correct defaults', function (): void {
        // Nessun modello dietro il form di login: niente precompilazione, mai la password.
        $fillData = (new LoginWidget)->getFormFill();

        Assert::assertArrayNotHasKey('password', $fillData);
    });

    test('login widget has correct view property', function (): void {
        $widget = new LoginWidget;
        $reflection = new ReflectionClass($widget);
        $property = $reflection->getProperty('view');
        $property->setAccessible(true);
        $view = $property->getValue($widget);

        Assert::assertSame('user::filament.widgets.login', $view);
    });

    test('login widget extends xot base widget', function (): void {
        $parents = class_parents(new LoginWidget);
        Assert::assertContains(XotBaseSchemaWidget::class, $parents);
        Assert::assertContains(BaseAuthWidget::class, $parents);
    });
});
