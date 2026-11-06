<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\User\Filament\Actions\Profile;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Actions\XotBaseAction;

/**
 * ---.
 */
final class ChangeProfilePasswordAction extends XotBaseAction
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
            ->action(static function (ProfileContract $record, array $data): void {
                $user = $record->user;
                $profileData = Arr::except($record->toArray(), ['id']);
                if ($user === null) {
                    /** @var UserContract */
                    $user = XotData::make()->getUserByEmail($record->email);
                }

                if ($user === null) {
                    /** @var array<string, mixed> $profileData */
                    $user = $record->user()->create($profileData);
                }

                if ($user instanceof UserContract && $record instanceof Model) {
                    $user->profile()->save($record);
                }

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
