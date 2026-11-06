<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Profile;

use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Chrome user-menu: toggle super-admin / negate-super-admin.
 *
 * Icone: SVG in resources/svg auto-registrati da
 * XotBaseServiceProvider::registerBladeIcons() (prefisso = alias modulo).
 * Attivo: superman.svg → user-superman.
 * Negato: clark-kent.svg → user-clark-kent.
 * Gli altri SVG (superadmin, scudo, user-*) restano in resources/svg, non si cancellano.
 *
 * Vista: convenzione GetViewByClassAction
 * user::filament.widgets.profile.super-admin.
 */
class SuperAdminWidget extends XotBaseWidget
{
    protected static bool $isDiscovered = false;

    public string $url = '#';

    public function mount(): void
    {
        $this->url = url()->current();
    }

    public function toggleSuperAdmin(): RedirectResponse|Redirector
    {
        XotData::make()->getProfileModel()->toggleSuperAdmin();

        return redirect($this->url, 303);
    }

    /**
     * Filament\Widgets\Widget::render() passa questi dati alla vista.
     *
     * @return array{profile: ProfileContract}
     */
    protected function getViewData(): array
    {
        return [
            'profile' => XotData::make()->getProfileModel(),
        ];
    }
}
