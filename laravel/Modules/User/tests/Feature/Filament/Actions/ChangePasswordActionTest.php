<?php

declare(strict_types=1);

use Modules\User\Filament\Actions\ChangePasswordAction;
use Tests\TestCase;

use function Safe\file_get_contents;

uses(TestCase::class);

/**
 * L'action e' `final` e la sua logica (schema, handler) vive in closure che servono un componente
 * Livewire montato: la configurazione statica si legge dall'istanza, il resto dal sorgente.
 */
function changePasswordActionSource(): string
{
    $file = (new ReflectionClass(ChangePasswordAction::class))->getFileName();

    return $file === false ? '' : file_get_contents($file);
}

test('change password action has correct default name', function (): void {
    expect(ChangePasswordAction::getDefaultName())->toBe('changePassword');
});

test('change password action has the key icon', function (): void {
    expect(ChangePasswordAction::make()->getIcon())->toBe('heroicon-o-key');
});

test('change password action asks for confirmation', function (): void {
    expect(ChangePasswordAction::make()->isConfirmationRequired())->toBeTrue();
});

test('change password action uses translation keys for tooltip and modal', function (): void {
    $action = ChangePasswordAction::make();

    expect($action->getTooltip())->toBe(__('user::user.actions.change_password'))
        ->and($action->getModalHeading())->toBe(__('user::password.actions.change_password.modal.heading'))
        ->and($action->getModalDescription())->toBe(__('user::password.actions.change_password.modal.description'));
});

test('change password action form uses password data and a matching confirmation field', function (): void {
    expect(changePasswordActionSource())
        ->toContain("PasswordData::make()->getPasswordFormComponent('new_password')")
        ->toContain("TextInput::make('new_password_confirmation')")
        ->toContain("->same('new_password')");
});

test('change password action hashes the new password and notifies success', function (): void {
    expect(changePasswordActionSource())
        ->toContain("'password' => Hash::make(\$newPassword)")
        ->toContain('Notification::make()')
        ->toContain('->success()');
});
