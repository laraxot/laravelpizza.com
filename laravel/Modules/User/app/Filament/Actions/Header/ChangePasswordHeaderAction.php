<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\User\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Contracts\UserContract;
use Webmozart\Assert\Assert;

final class ChangePasswordHeaderAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            ->icon('heroicon-o-key')
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
                    /*
                     * TextInput::make('new_password')
                     * ->password()
                     *
                     * ->placeholder(__('user::fields.new_password.placeholder'))
                     * ->required()
                     * ->rule(Password::default()),
                     */
                    PasswordData::make()->getPasswordFormComponent('new_password'),
                    TextInput::make('new_password_confirmation')
                        ->password()
                        ->placeholder(__('user::fields.confirm_password.placeholder'))
                        ->rule(
                            'required',
                            /**
                             * @param  callable(string): mixed  $get
                             */
                            static fn (callable $get): bool => (bool) $get('new_password')
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

/*
 * Action::make('changePassword')
 * ->action(function (UserContract $user, array $data): void {
 * $user->update([
 * 'password' => Hash::make($data['new_password']),
 * ]);
 * Notification::make()->success()->title('Password changed successfully.');
 * })
 * ->form([
 * TextInput::make('new_password')
 * ->password()
 * ->required()
 * ->rule(Password::default()),
 * TextInput::make('new_password_confirmation')
 * ->password()
 * ->rule('required', fn ($get): bool => (bool) $get('new_password'))
 * ->same('new_password'),
 * ])
 * ->icon('heroicon-o-key')
 * // ->visible(fn (User $record): bool => $record->role_id === Role::ROLE_ADMINISTRATOR)
 */
