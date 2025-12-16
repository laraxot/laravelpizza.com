<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Panel;

use Filament\Panel;
use Modules\User\Filament\Pages\Tenancy\EditTenantProfile;
use Modules\User\Filament\Pages\Tenancy\RegisterTenant;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

class ApplyTenancyToPanelAction
{
    use QueueableAction;

    public function execute(Panel &$panel): Panel
    {
        $tenant_class = XotData::make()->getTenantClass();

        // $panel
        //     ->tenant($tenant_class, slugAttribute: 'slug')
        //     ->tenantRegistration(RegisterTenant::class)
        //     ->tenantProfile(EditTenantProfile::class);

        // Controlla se l'utente è superadmin
        // $user = Auth::user();

        // if (Gate::allows('superadmin', $user)) {
        // Configurazione completa per superadmin
        $panel
            ->tenant($tenant_class, 'slug', 'tenants')
            ->tenantRegistration(RegisterTenant::class)
            ->tenantProfile(EditTenantProfile::class);
        // } else {
        // Configurazione limitata per non-superadmin
        // $panel->tenant($tenant_class, slugAttribute: 'slug');
        // }

        return $panel;
    }
}
