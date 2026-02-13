<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class UserDropdown extends XotBaseWidget
{
    /**
     * The view for this widget.
     */
    protected string $view = 'user::filament.widgets.user-dropdown';

    /**
     * Handle user logout.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/'.app()->getLocale(), navigate: true);
    }

    /**
     * Get the form schema.
     * Required by XotBaseWidget but not used for this simple dropdown.
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Get view data for the widget.
     * Standardized way to pass data in XotBaseWidget.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $user = Auth::user();
        $profile = $user?->profile;

        return [
            'user' => $user,
            'avatarUrl' => $profile?->getAvatarUrl() ?? 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y',
            'name' => $user?->name ?? 'User',
        ];
    }
}
