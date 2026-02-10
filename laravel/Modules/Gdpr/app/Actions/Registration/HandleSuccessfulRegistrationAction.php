<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Registration;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\User;
use Modules\Xot\Filament\Widgets\XotBaseWidget; // Use the base widget for type hinting
use Spatie\QueueableAction\QueueableAction;
use function __;

class HandleSuccessfulRegistrationAction
{
    use QueueableAction;

    public function execute(User $user, XotBaseWidget $widget): void
    {
        Auth::login($user);

        Notification::make()
            ->title(__('gdpr::register.success'))
            ->body(__('gdpr::register.success_message'))
            ->success()
            ->send();

        $widget->redirect(route('dashboard'));
    }
}
