<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

use function Safe\preg_split;

class UserDropdown extends XotBaseSchemaWidget
{
    /**
     * The view for this widget.
     */
    protected string $view = 'user::filament.widgets.user-dropdown';

    /**
     * Il nome e la foto cambiano dalla pagina "Modifica il profilo" (evento Livewire `profile-updated`): ridisegna il menu.
     */
    #[On('profile-updated')]
    public function refreshUser(): void {}

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
            'avatarUrl' => $this->resolveAvatarUrl($profile),
            'name' => $user->name ?? 'User',
            'initials' => $this->initials((string) ($user->name ?? '')),
        ];
    }

    /**
     * Iniziali (max 2) mostrate quando non c'e' una foto: nessuna richiesta a siti terzi.
     */
    private function initials(string $name): string
    {
        $letters = [];
        foreach (preg_split('/\s+/u', trim($name)) as $word) {
            if (is_string($word) && $word !== '') {
                $letters[] = mb_strtoupper(mb_substr($word, 0, 1));
            }
        }

        return implode('', array_slice($letters, 0, 2));
    }

    /**
     * URL della foto del profilo, o stringa vuota: la vista mostra allora le iniziali.
     */
    private function resolveAvatarUrl(?object $profile): string
    {
        $fallback = '';

        if (! \is_object($profile)) {
            return $fallback;
        }

        if (method_exists($profile, 'getAvatarUrl')) {
            $url = $profile->getAvatarUrl();
            if (\is_string($url) && $url !== '') {
                return $url;
            }
        }

        $avatarUrl = $profile->avatar_url ?? null;

        return \is_string($avatarUrl) && $avatarUrl !== '' ? $avatarUrl : $fallback;
    }
}
