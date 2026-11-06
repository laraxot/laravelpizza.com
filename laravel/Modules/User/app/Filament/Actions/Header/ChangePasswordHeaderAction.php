<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\User\Filament\Actions\Header;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Webmozart\Assert\Assert;

final class ChangePasswordHeaderAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            ->tooltip(__('user::user.actions.change_password'))
            ->icon('heroicon-o-key')
            ->requiresConfirmation()
            ->modalHeading(__('user::password.actions.change_password.modal.heading'))
            ->modalDescription(__('user::password.actions.change_password.modal.description'))
            ->action(function (array $data): void {
                $record = Auth::user();
                Assert::isInstanceOf($record, UserContract::class);

                $newPassword = is_string($data['new_password'] ?? null) ? $data['new_password'] : '';

                $record->update([
                    'password' => Hash::make($newPassword),
                ]);

                Notification::make()
                    ->success()
                    ->title(__('user::notifications.password_changed_successfully.title'))
                    ->body(__('user::notifications.password_changed_successfully.message'))
                    ->send();
            })
            ->schema(function (): array {
                return [
                    PasswordData::make()->getPasswordFormComponent('new_password'),
                    TextInput::make('new_password_confirmation')
                        ->password()
                        ->placeholder(__('user::fields.confirm_password.placeholder'))
                        ->rule(
                            'required',
                            static fn (Get $get): bool => (bool) $get('new_password')
                        )
                        ->same('new_password'),
                ];
            });
    }

    public static function getDefaultName(): string
    {
        return 'changePassword';
    }
}
