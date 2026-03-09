<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Schemas\Components\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LogoutWidget extends XotBaseWidget
{
    protected string $view = 'user::widgets.logout';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            'message' => View::make('filament.widgets.auth.logout-message')->columnSpanFull(),
        ];
    }

    public function logout(): void
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
        redirect($this->getLocalizedHomeUrl());
    }

    public function getFormActions(): array
    {
        return [
            'logout' => $this->getLogoutAction(),
            'cancel' => $this->getCancelAction(),
        ];
    }

    protected function getLogoutAction(): Action
    {
        return Action::make('logout')
            ->label('Logout')
            ->color('danger')
            ->action(fn () => $this->logout());
    }

    protected function getCancelAction(): Action
    {
        return Action::make('cancel')
            ->label('Annulla')
            ->color('gray')
            ->url($this->getLocalizedHomeUrl());
    }

    protected function getLocalizedHomeUrl(): string
    {
        return '/'.App::getLocale();
    }
}
