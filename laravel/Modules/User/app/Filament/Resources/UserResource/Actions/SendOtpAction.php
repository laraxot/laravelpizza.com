<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Actions;

use Filament\Actions\Action;
use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Models\User;

class SendOtpAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tooltip(trans('user::otp.actions.send_otp'))
            ->icon('heroicon-o-key')
            ->action(function (User $record): void {
                app(SendOtpByUserAction::class)->execute($record);
            })
            ->requiresConfirmation()
            ->modalHeading(trans('user::otp.actions.send_otp'))
            ->modalSubheading(trans('user::otp.actions.confirm_otp'))
            ->modalButton(trans('user::otp.actions.yes_send_otp'));
    }

    public static function getDefaultName(): ?string
    {
        return 'send_otp';
    }
}
