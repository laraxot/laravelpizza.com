<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * AuthLogoutWidget: widget per il logout dal panel Filament.
 *
 * Sostituisce il vecchio Livewire `Modules\User\Http\Livewire\Auth\AuthLogout`.
 */
final class AuthLogoutWidget extends XotBaseWidget
{
    public function mount(): void
    {
        Auth::logout();
    }

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'user::filament.widgets.auth.logout';

        return view($viewName);
    }
}
