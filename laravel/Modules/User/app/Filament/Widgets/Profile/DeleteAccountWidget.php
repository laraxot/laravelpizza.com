<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Modules\User\Actions\User\DeleteUserAction;
use Modules\User\Contracts\UserContract;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * DeleteAccountWidget: widget per la cancellazione dell'account dal menu utente.
 *
 * Sostituisce il vecchio Livewire `Modules\User\Http\Livewire\Profile\DeleteAccount`.
 */
final class DeleteAccountWidget extends XotBaseWidget
{
    public string $delete_confirm_password = '';

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'user::filament.widgets.profile.delete-account';

        return view($viewName);
    }

    public function destroy(): void
    {
        /** @var UserContract|null $user */
        $user = Auth::user();
        if (! $user) {
            $this->dispatch('toast', [
                'message' => __('user::messages.user_not_found'),
                'type' => 'error',
            ]);

            return;
        }

        if (! $user instanceof UserContract) {
            $this->dispatch('toast', [
                'message' => __('user::messages.user_invalid'),
                'type' => 'error',
            ]);

            return;
        }

        app(DeleteUserAction::class)->execute($user, $this->delete_confirm_password);
    }
}
