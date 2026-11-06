<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Actions;

use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Models\User;
use Modules\Xot\Filament\Actions\XotBaseAction;

/**
 * Azione Filament per l'invio di un OTP all'utente.
 */
class SendOtpAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tooltip(trans('user::otp.actions.send_otp'))
            ->icon('heroicon-o-key')
            ->action(function (User $record): void {
                // User already implements UserContract, no need for assertion
                $action = app(SendOtpByUserAction::class);
                if ($action === null) {
                    throw new \RuntimeException('Impossibile istanziare SendOtpByUserAction');
                }
                // PHPStan Level 10: User extends BaseUser which implements UserContract
                $action->execute($record);
            })
            ->requiresConfirmation()
            ->modalHeading(trans('user::otp.actions.send_otp'))
            ->modalDescription(trans('user::otp.actions.confirm_otp'))
            ->modalSubmitActionLabel(trans('user::otp.actions.yes_send_otp'));
    }

    /**
     * Ottieni il nome predefinito dell'azione.
     */
    public static function getDefaultName(): ?string
    {
        return 'send_otp';
    }
}
