<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class UserDropdown extends XotBaseWidget
{
    protected string $view = 'user::filament.widgets.user-dropdown';

    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/');
    }

    public function getFormSchema(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        $user = Auth::user();

        return [
            'user' => $user,
            'avatarUrl' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y',
            'name' => $user?->name ?? 'User',
        ];
    }
}
