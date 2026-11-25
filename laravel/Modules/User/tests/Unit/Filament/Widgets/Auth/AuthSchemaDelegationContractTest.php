<?php

declare(strict_types=1);

use Modules\User\Filament\Resources\UserResource\Schemas\UserForm;
use Modules\User\Filament\Widgets\Auth\ForgotPasswordWidget;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Filament\Widgets\Auth\PasswordResetConfirmWidget;
use Modules\User\Filament\Widgets\Auth\PasswordResetWidget;
use Modules\User\Filament\Widgets\Auth\RegisterWidget;
use Modules\User\Filament\Widgets\Auth\ResetPasswordWidget;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

uses(TestCase::class);

dataset('auth schema widgets', [
    [LoginWidget::class, 'getLoginFormSchema'],
    [RegisterWidget::class, 'getRegisterFormSchema'],
    [ForgotPasswordWidget::class, 'getForgotPasswordFormSchema'],
    [PasswordResetWidget::class, 'getPasswordResetFormSchema'],
    [ResetPasswordWidget::class, 'getResetPasswordFormSchema'],
    [PasswordResetConfirmWidget::class, 'getPasswordResetConfirmFormSchema'],
]);

/** @see ../../../../../../Xot/docs/bmad/livewire-widget-decision-log.md */
test('auth schema widgets use the shared UserForm contract', function (string $widgetClass, string $schemaMethod): void {
    if (! class_exists($widgetClass)) {
        throw new InvalidArgumentException(sprintf('Auth widget class [%s] does not exist.', $widgetClass));
    }

    $reflection = new ReflectionClass($widgetClass);

    expect($reflection->isSubclassOf(XotBaseSchemaWidget::class))->toBeTrue();

    $formClass = $reflection->getMethod('formClass');
    $formClass->setAccessible(true);
    expect($formClass->invoke(null))->toBe(UserForm::class);

    $method = $reflection->getMethod('schemaMethod');
    $method->setAccessible(true);
    expect($method->invoke(null))->toBe($schemaMethod);

    expect(method_exists(UserForm::class, $schemaMethod))->toBeTrue();
    expect(UserForm::{$schemaMethod}())->toBeArray()->not->toBeEmpty();
})->with('auth schema widgets');

